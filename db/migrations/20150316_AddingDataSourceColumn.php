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

class AddingDataSourceColumn_1426506128  extends LazyRecord\Migration\Migration {

    public function upgrade() {
        $this->executeSql('ALTER TABLE stations ADD COLUMN data_source varchar(60);');
        $this->executeSql("UPDATE stations SET data_source = 'TaiwanEPADataSource' WHERE country_en = 'Taiwan'" );
        $this->executeSql("UPDATE stations SET data_source = 'ChinaDataSource' WHERE country_en = 'China'" );
        $this->executeSql("UPDATE stations SET data_source = 'JapanSoramameDataSource' WHERE country_en = 'Japan'" );
    }

    public function downgrade() {
    
    }

}
