<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class MetricUnitSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('id')->smallint()->primary()->autoIncrement()->unsigned()->notNull();
        $this->column('identifier')->varchar(30)->notNull();
        $this->column('label')->varchar(30); // mg
        $this->column('form')->varchar(30); // mg/m3 ..
    }
}
