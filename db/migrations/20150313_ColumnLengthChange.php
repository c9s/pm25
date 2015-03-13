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

class ColumnLengthChange_1426224507  extends LazyRecord\Migration\Migration {

    public function upgrade() {
        $this->executeSql('ALTER TABLE stations CHANGE COLUMN address_en address_en varchar(128)');
        $this->executeSql('ALTER TABLE stations CHANGE COLUMN city_en city_en varchar(60)');
        $this->executeSql('ALTER TABLE stations CHANGE COLUMN name_en name_en varchar(60)');
    }

    public function downgrade() {
    
    }

}
