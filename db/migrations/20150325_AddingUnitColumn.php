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

class AddingUnitColumn_1427213914  extends LazyRecord\Migration\Migration {


    public function upgrade() {
        $this->executeSql('ALTER TABLE measure_attributes ADD COLUMN unit varchar(10)');
    }

    public function downgrade() {
        $this->executeSql('ALTER TABLE measure_attributes DROP COLUMN unit');
    }

}
