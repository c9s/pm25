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

class AddGeneralMeasureQueryIndex_1427103797  extends LazyRecord\Migration\Migration {


    public function upgrade() {
        $this->executeSql('CREATE INDEX general_measure_query_idx ON measures (station_id, published_at)');
    }

    public function downgrade() {
        $this->executeSql('DROP INDEX general_measure_query_idx ON measures');
    }

}
