<?php
namespace PM25\DataSource\Asia;
// use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use DOMElement;
use DOMText;
use CLIFramework\Logger;
use PM25\DataSource\BaseDataSource;
use CurlKit\CurlAgent;
use PM25\Exception\IncorrectDataException;

class JapanSoramameDataSource extends BaseDataSource
{
    const BASE_URL = 'http://soramame.taiki.go.jp';

    const PROVINCE_LIST_PAGE = '/MstItiran.php';

    const STATION_LIST_PAGE = '/MstItiranHyou.php?Pref={city}&Time={time}';

    const STATION_TITLE_PAGE = '/MstItiranTitle.php?Time={time}';

    public function getProvinceListPageUrl() {
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
                echo "Station info not found in ", $countyStationRow->C14N() , "\n";
                echo "Skipping to next row\n";
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
            // echo get_class($item) , "=>", trim($span->textContent), "\n";
            // echo get_class($item), " => ", $item->C14N() , "\n";
            $attributeNames[] = trim($span->textContent);
        }
        return $attributeNames;
    }

    public function updateStationDetails() {
        $this->logger->info('Fetching province list ' . $this->getProvinceListPageUrl());
        
        $crawler = new Crawler(file_get_contents($this->getProvinceListPageUrl()));
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
            foreach($stations as $station) {
                $this->logger->info(' - ' . join(', ', [$station['name'], $station['code'], $station['address']]));
            }
        }
    }
}




