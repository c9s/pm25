<?php

/**
 * To upgrade with new schema:
 *    $this->importSchema(new TestApp\AuthorBookSchema);
 *
 * To rename table column:
 *    $this->renameColumn($table, $columnName, $newColumnName);
 *
 * To create index:
 *    $this->createIndex($table,$indexName,$columnNames);
 *
 * To drop index:
 *    $this->dropIndex($table,$indexName);
 *
 * To add a foreign key:
 *    $this->addForeignKey($table,$columnName,$referenceTable,$referenceColumn = null) 
 *
 * To drop table:
 *    $this->dropTable('authors');
 */

class Index_1426072879  extends LazyRecord\Migration\Migration {


    public function upgrade() {
        $this->executeSql('alter table measures add foreign key (station_id) REFERENCES stations(id);');
        $this->executeSql('create index station_text_all_search_idx ON stations (country,country_en,city,city_en,name,name_en,address,address_en);');
        $this->executeSql('create index station_text_en_search_idx ON stations (country_en,city_en,name_en,address_en);');
        $this->executeSql('create index station_text_search_idx ON stations (country,city,name,address);');
        $this->executeSql('create index recent_measures_idx ON measures (station_id, pm25, pm10, id DESC);');
    }

    public function downgrade() {
        $this->executeSql('drop index station_text_all_search_idx ON stations');
        $this->executeSql('drop index station_text_en_search_idx ON stations');
        $this->executeSql('drop index station_text_search_idx ON stations');
        $this->executeSql('drop index recent_measures_idx ON stations');
    
    }

}
