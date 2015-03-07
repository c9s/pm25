<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class SiteSchema extends SchemaDeclare
{
    public function schema() {


        $this->column('country')->varchar(30);

        $this->column('city')->varchar(30);

        $this->column('name')->varchar(30);

        $this->column('longitude')->double();

        $this->column('latitude')->double();
    }
}
