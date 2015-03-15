<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class StationSchema extends SchemaDeclare
{
    public function schema() {
        $this->table('stations');

        $this->column('country')->varchar(30);

        $this->column('country_en')->varchar(60);

        $this->column('city')->varchar(30);

        $this->column('city_en')->varchar(60);

        $this->column('name')->varchar(30);

        $this->column('name_en')->varchar(60);

        $this->column('address')->varchar(60);

        $this->column('address_en')->varchar(120);

        $this->column('area')->varchar(30);

        $this->column('area_en')->varchar(60);

        $this->column('longitude')->double()->isa('double');

        $this->column('latitude')->double()->isa('double');

        $this->column('rawdata')->text();

        $this->column('location')->type('point');

        $this->column('support_uv')->boolean();

        $this->column('support_air')->boolean();

        $this->column('remark')->json();
    }
}
