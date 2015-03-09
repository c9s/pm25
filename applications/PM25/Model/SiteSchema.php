<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class SiteSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('country')->varchar(30);

        $this->column('country_en')->varchar(30);

        $this->column('city')->varchar(30);

        $this->column('city_en')->varchar(30);

        $this->column('name')->varchar(30);

        $this->column('name_en')->varchar(60);

        $this->column('address')->varchar(60);

        $this->column('address_en')->varchar(60);

        $this->column('longitude')->double();

        $this->column('latitude')->double();
    }
}
