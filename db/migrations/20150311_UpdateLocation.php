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

class UpdateLocation_1426057233  extends LazyRecord\Migration\Migration {

    public function upgrade() {
        $this->executeSql('UPDATE stations s SET location = POINT(s.latitude, s.longitude) WHERE s.latitude IS NOT NULL AND s.longitude IS NOT NULL');
    }

    public function downgrade() {
    
}

}
