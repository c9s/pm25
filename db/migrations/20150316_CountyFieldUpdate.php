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

class CountyFieldUpdate_1426505836  extends LazyRecord\Migration\Migration {

    public function upgrade() {
        $this->executeSql('UPDATE stations SET county = city WHERE city IS NOT NULL');
        $this->executeSql('UPDATE stations SET county_en = city_en WHERE city_en IS NOT NULL');
    }

    public function downgrade() {
    
    }

}
