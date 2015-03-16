<?php
namespace PM25\DataSource\Asia;
use PM25\DataSource\BaseDataSource;
use PM25\Exception\IncorrectDataException;
use Symfony\Component\DomCrawler\Crawler;
use CLIFramework\Logger;
use CurlKit\CurlAgent;
use DOMElement;
use DOMText;
use PM25\Model\Station;
use PM25\Model\StationCollection;

class JapanSoramameDataSource extends BaseDataSource
{
    const BASE_URL = 'http://soramame.taiki.go.jp';

    const PROVINCE_LIST_PAGE = '/MstItiran.php';

    const STATION_LIST_PAGE = '/MstItiranHyou.php?Pref={city}&Time={time}';

    const STATION_TITLE_PAGE = '/MstItiranTitle.php?Time={time}';

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

    public function updateStationDetails() {
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
            $this->logger->info("Parsing stations for county " . $county);
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
                ], ['name', 'county', 'country']);

                if (!$ret->success) {
                    $this->logger->error('Station record create or update failed: ' .$ret->message);
                }

                if (!$station->latitude && !$station->longitude) {
                    $this->logger->info('Updating geolocation from address');
                    // Translate the address to latitude and longitude
                    $station->updateLocation();
                }
            }
            $this->logger->info('Sleeping 30 seconds...');
            // sleep a while for later parsing
            sleep(30);
        }
    }

    public function updateMeasurements() {


    }
}




