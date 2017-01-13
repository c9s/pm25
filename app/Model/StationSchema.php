<?php
namespace App\Model;
use LazyRecord\Schema\SchemaDeclare;

class StationSchema extends SchemaDeclare
{
    public function schema() {
        $this->table('stations');

        $this->column('id')->mediumInt()->primary()->unsigned()->notNull()->autoIncrement();

        $this->column('country')->varchar(30);

        $this->column('country_en')->varchar(60);

        $this->column('city')->varchar(30);
        $this->column('city_en')->varchar(60);

        $this->column('county')->varchar(30);
        $this->column('county_en')->varchar(60);

        $this->column('province')->varchar(60);
        $this->column('province_en')->varchar(60);

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

        $this->column('remark')->text();

        $this->column('code')->varchar(32);

        $this->column('data_source')->varchar(64);

        $this->many('station_measure_attributes', 'PM25\Model\StationMeasureAttributeSchema', 'station_id', 'id');
        $this->manyToMany('measure_attributes', 'station_measure_attributes', 'attribute');

        $this->many('measurements', 'PM25\\Model\\MeasureSchema', 'station_id', 'id')
            ->orderBy('published_at', 'DESC')
            ;
    }
}
