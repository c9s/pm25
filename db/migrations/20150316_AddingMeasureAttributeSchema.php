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

class AddingMeasureAttributeSchema_1426517709  extends LazyRecord\Migration\Migration {
    public function upgrade() {
        $this->importSchema(new App\Model\StationMeasureAttributeSchema);
        $this->importSchema(new App\Model\MeasureAttributeSchema);
    }

    public function downgrade() {
    
    }
}
