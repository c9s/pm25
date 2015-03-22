<?php
namespace PM25\DataSource\Asia;
use Symfony\Component\DomCrawler\Crawler;
use CLIFramework\Logger;
use CurlKit\CurlAgent;
use PM25\DataSource\BaseDataSource;
use PM25\Exception\IncorrectDataException;
use PM25\Model\Station;
use PM25\Model\StationCollection;
use PM25\Model\Measure;
use DOMElement;
use DOMText;
use DateTime;
use DateTimeZone;

function measurement_description(array $data) {
    $out = [];
    foreach ($data as $key => $val) {
        if (!in_array($key, [ 'published_at', 'station_id' ])) {
            $out[] = sprintf("%s:%.3f", $key, $val);
        }
    }
    return join(', ', $out);
}

class JapanSoramameDataSource extends BaseDataSource
{
    const BASE_URL = 'http://soramame.taiki.go.jp';

    const PROVINCE_LIST_PAGE = '/MstItiran.php';

    const STATION_LIST_PAGE = '/MstItiranHyou.php?Pref={city}&Time={time}';

    const STATION_TITLE_PAGE = '/MstItiranTitle.php?Time={time}';

    const MEASUREMENT_TITLE_PAGE = '/DataListTitle.php?MstCode={code}&Time={time}';

    const MEASUREMENT_DATA_PAGE = '/DataListHyou.php?MstCode={code}&Time={time}';

    public function getCountyListPageUrl() {
        return self::BASE_URL . self::PROVINCE_LIST_PAGE;
    }

    public function getStationTitlePageUrl() {
        return self::BASE_URL . 
            str_replace(['{time}' ], [date('YmdH') ], 
                self::STATION_TITLE_PAGE);
    }

    public function getStationListPageUrl($cityId) {
        return self::BASE_URL . 
            str_replace([ '{city}', '{time}' ], [ $cityId, date('YmdH') ], 
                self::STATION_LIST_PAGE);
    }

    public function getMeasurementTitlePageUrl($code) {
        return self::BASE_URL . 
            str_replace([ '{code}', '{time}' ], [ $code, date('YmdH') ], 
                self::MEASUREMENT_TITLE_PAGE);
    }

    public function getMeasurementDataPageUrl($code) {
        return self::BASE_URL . 
            str_replace([ '{code}', '{time}' ], [ $code, date('YmdH') ], 
                self::MEASUREMENT_DATA_PAGE);
    }

    public function parseCountyStations($attributeNames, $pageUrl) {
        $response = $this->agent->get($pageUrl);
        $pageHtml = $response->decodeBody();

        $dataCrawler = new Crawler($pageHtml);
        $countyStationRows = $dataCrawler->filter('table.hyoMenu tr');
        $stations = array();
        foreach ($countyStationRows as $countyStationRow) {
            $stationInfo = $this->parseCountyStationRow($countyStationRow);

            if (empty($stationInfo)) {
                $this->logger->warn('Empty station info, row: ' . $countyStationRow->C14N());
                continue;
            }

            if (count($attributeNames) == count($stationInfo['attributes'])) {
                $stationInfo['attributes'] = array_combine($attributeNames, $stationInfo['attributes']);
            } else {
                throw new IncorrectDataException('Inequal attribute numbers', $pageUrl, $stationInfo, $countyStationRow->C14N());
            }
            if (!$stationInfo['code'] && !$stationInfo['name'] && !$stationInfo['address']) {
                $this->logger->warn('Station info not found in ' . $countyStationRow->C14N());
                $this->logger->info('Skipping to next row');
                continue;
            }
            $stations[] = $stationInfo;
        }
        return $stations;
    }

    public function parseCountyStationRow(DOMElement $row) {
        $rowCrawler = new Crawler($row);
        $columnElements = $row->getElementsByTagName('td');
        $mstCode = $columnElements->item(0)->textContent;
        $mstName = $columnElements->item(1)->textContent;
        $mstAddress = $columnElements->item(2)->textContent;

        $attributes = array();
        $supportedAttributeColumns = $rowCrawler->filter('.MstHyo_Co, .MstHyo');
        foreach($supportedAttributeColumns as $attrbuteColumn) {
            if (preg_match('/○/',$attrbuteColumn->textContent)) {
                $attributes[] = true;
            } elseif (preg_match('/×/',$attrbuteColumn->textContent)) {
                $attributes[] = false;
            } else {
                $attributes[] = null;
            }
        }
        return [
            'code' => trim($mstCode),
            'name' => trim($mstName),
            'address' => trim($mstAddress),
            'attributes' => $attributes,
        ];
    }

    public function buildAttributeTable($html) {
        $attributeCrawler = new Crawler($html);
        $attributeRow = $attributeCrawler->filter('.hyoMenu .hyoMenu_Komoku')->eq(1)->getNode(0);
        // print_r($attributeRow);

        $attributeNames = [];
        $children = $attributeRow->childNodes;
        foreach($children as $item) {
            if ($item instanceof DOMText) {
                continue;
            }
            $span = $item->childNodes->item(0);
            $attributeNames[] = trim($span->textContent);
        }
        return $attributeNames;
    }

    public function updateStationDetails(array $options = array()) {
        $this->logger->info('Fetching county list ' . $this->getCountyListPageUrl());
        
        $crawler = new Crawler(file_get_contents($this->getCountyListPageUrl()));
        $crawler = $crawler->filter('.DataKoumoku select[name="ListPref"] option');
        $counties = array();
        foreach($crawler as $i => $countyOption) {
            $countyId = $countyOption->getAttribute('value');
            if ($countyId == 0) {
                continue;
            }

            // print_r($cityOption);
            $countyName = trim($countyOption->textContent);
            $counties[ $countyId ] = $countyName;
        }

        $this->logger->info('Parsing station attributes ' . $this->getStationTitlePageUrl());
        $response = $this->agent->get($this->getStationTitlePageUrl());
        $attributeNames = $this->buildAttributeTable($response->decodeBody());
        foreach($counties as $countyId => $county) {
            if (isset($options['start_from']) && $options['start_from'] != $county && $options['start_from'] != $countyId) {
                continue;
            }

            $this->logger->info("Parsing stations for county " . $county . ' (' . $countyId . ')');
            $stations = $this->parseCountyStations($attributeNames, $this->getStationListPageUrl($countyId));
            foreach($stations as $stationInfo) {
                $this->logger->info(' - Station ' . join(', ', [$stationInfo['name'], $stationInfo['code'], $stationInfo['address']]));

                $station = new Station;
                $ret = $station->createOrUpdate([  
                    'name' => $stationInfo['name'],
                    'address' => $stationInfo['address'],
                    'code' => $stationInfo['code'],
                    'city' => $county,
                    'county' => $county,
                    'data_source' => 'JapanSoramameDataSource',
                    'country' => '日本國',
                    'country_en' => 'Japan',
                    'rawdata' => yaml_emit($stationInfo, YAML_UTF8_ENCODING),
                ], ['code']);

                if (!$ret->success || $ret->error) {
                    $this->logger->error('Station record create or update failed: ' .$ret->message);
                }

                // just make sure we have the record.
                if ($station->id) {
                    if (!$station->latitude && !$station->longitude) {
                        $this->logger->info('Updating geolocation from address');
                        // Translate the address to latitude and longitude
                        $station->updateLocation();
                    }
                    $station->importAttributes($stationInfo['attributes']);
                    $importedAttrs = $station->getAttributeArray();
                }

            
            }
            $this->logger->info('Sleeping 30 seconds...');
            // sleep a while for later parsing
            sleep(30);
        }
    }

    public function updateMeasurements()
    {
        $stations = new StationCollection;
        $stations->where([  'country_en' => 'Japan' ]);
        foreach ($stations as $station) {
            $this->logger->info("Parsing measurements from station: {$station->name}");
            $this->updateMeasurementsFor($station);
        }
    }

    public function updateMeasurementsFor(Station $station)
    {
        $timestamp = date('Ymdh');

        // parse measurement header
        $response = $this->agent->get($this->getMeasurementTitlePageUrl($station->code));
        $html = $response->decodeBody();

        // $html = file_get_contents('japan/DataListTitle.php?MstCode=44201010&Time=2015031517');

        $crawler = new Crawler($html);
        $titleTable = $crawler->filter('table.hyoMenu')->eq(1); // get the second table
        $titleRows = $titleTable->children();
        $elementRow = $titleRows->eq(0);
        $elementCells = $elementRow->children();

        $unitRow = $titleRows->eq(1);
        $unitCells = $unitRow->children();


        $functionalRow = $titleRows->eq(2);
        $functionalCells = $functionalRow->children();


        $labels = [];
        foreach($elementCells as $index => $cell) {
            // Skip text nodes
            if ($cell instanceof DOMText) {
                continue;
            }
            $labels[] = $cell->textContent;
        } 
        array_splice($labels, 0, 4); // year, month, day, hour
        $labels = array_map('strtolower', $labels); // transform text to lower


        $units = [];
        foreach($unitCells as $cell) {
            if ($cell instanceof DOMText) {
                continue;
            }
            $units[] = $cell->textContent;
        }

        // Align the rowspan for units
        foreach($elementCells as $index => $cell) {
            if ($cell instanceof DOMText) {
                continue;
            }
            $rowspan = intval($cell->getAttribute("rowspan"));
            if ($rowspan > 1) {
                $this->logger->debug("Make a room from index $index => $rowspan");
                array_splice($units, $index, 0, ['_']);
            }
        }
        array_splice($units, 0 , 4);

        $labelUnits = array_combine($labels, $units);

        /*
        print_r( $labels ); 
        print_r( $units);
        print_r( $labelUnits ); 
        */

        // parse measurement body
        $response = $this->agent->get($this->getMeasurementDataPageUrl($station->code));
        $html = $response->decodeBody();
        // $html = mb_convert_encoding($html, 'utf-8', 'EUC-JP');
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('table.hyoMenu tr');

        $this->logger->info("Found " . $crawler->count() .  " records.");
        foreach ($crawler as $row) {
            $cells = $row->childNodes;
            $rowContents = [];
            foreach ($cells as $cell) {
                // Skip text nodes
                if ($cell instanceof DOMText) {
                    continue;
                }
                $rowContents[] = $cell->textContent;
            }
            $year = array_shift($rowContents);
            $month = array_shift($rowContents);
            $day = array_shift($rowContents);
            $hour = array_shift($rowContents);

            $minute = 0;
            $datetime = new DateTime();
            $datetime->setTimeZone(new DateTimeZone('Asia/Tokyo'));
            $datetime->setDate( intval($year), intval($month), intval($day) );
            $datetime->setTime( intval($hour), $minute);

            $this->logger->info("Measurement time: " . $datetime->format(DateTime::ATOM));

            
            $measureData = array_combine($labels, $rowContents);
            $measureData = array_filter($measureData, 'is_numeric');
            $measureData = array_map('doubleval',$measureData);
            $measureData = array_merge($measureData, [
                'published_at' => $datetime->format(DateTime::ATOM),
                'station_id' => $station->id,
            ]);

            $this->logger->info("Data: " . measurement_description($measureData));
            $measurement = new Measure;
            $ret = $measurement->createOrUpdate($measureData, ['published_at' , 'station_id']);
            if ($ret->error) {
                $this->logger->error($ret->message);
            }
        }
    }
}




