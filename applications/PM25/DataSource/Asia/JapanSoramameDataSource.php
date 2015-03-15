<?php
namespace PM25\DataSource\Asia;
// use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use DOMElement;
use DOMText;

class JapanSoramameDataSource
{
    public function parseForCities($attributeNames, $cityDataHtml) {
        // print_r($attributeNames);
        $dataCrawler = new Crawler($cityDataHtml);
        $cityStationRows = $dataCrawler->filter('table.hyoMenu tr');
        $stations = array();
        foreach ($cityStationRows as $cityStationRow) {
            // print_r($cityStationRow);
            $stationInfo = $this->parseCityStationRow($cityStationRow);
            if (count($attributeNames) == count($stationInfo['attributes'])) {
                $stationInfo['attributes'] = array_combine($attributeNames, $stationInfo['attributes']);
            } else {
                echo "Inequal attribute numbers at ", var_export($stationInfo, true), "\n";
                echo $cityStationRow->C14N();
                exit(0);
            }
            if (!$stationInfo['code'] && !$stationInfo['name'] && !$stationInfo['address']) {
                echo "Station info not found in ", $cityStationRow->C14N() , "\n";
                echo "Skipping to next row\n";
                continue;
            }
            print_r($stationInfo);
            $stations[] = $stationInfo;
        }
        return $stations;
    }

    public function parseCityStationRow(DOMElement $row) {
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
            'code' => $mstCode,
            'name' => $mstName,
            'address' => $mstAddress,
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
        $crawler = new Crawler(file_get_contents('japan/MstItiran.php'));
        $crawler = $crawler->filter('.DataKoumoku select[name="ListPref"] option');
        foreach($crawler as $i => $cityOption) {
            $cityId = $cityOption->getAttribute('value');
            if ($cityId == 0) {
                continue;
            }

            // print_r($cityOption);
            $cityName = $cityOption->textContent;
            
            echo "Parsing stations for ", $cityName, "\n";

            // XXX:
            $cityId = '08';

            $attributeNames = $this->buildAttributeTable(file_get_contents('japan/MstItiranTitle.php?Time=2015031516'));
            $stations = $this->parseForCities($attributeNames, file_get_contents("japan/MstItiranHyou.php?Pref={$cityId}&Time=2015031516"));
            return $stations;
        }
    }
}




