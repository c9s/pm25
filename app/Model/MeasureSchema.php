<?php
namespace App\Model;
use LazyRecord\Schema\SchemaDeclare;

class MeasureSchema extends SchemaDeclare
{
    public function schema() 
    {
        $this->column('id')->bigint()->unsigned()->primary()->notNull()->autoIncrement();

        $this->column('station_id')->mediumint()->notNull();

        $this->column('pm10')->double(5,2)->default(0);

        $this->column('pm25')->double(5,2)->default(0);

        $this->column('no2')->double()->default(0);

        $this->column('fpmi')->double()->default(0);

        $this->column('so2')->double()->default(0);

        $this->column('co')->double()->default(0);

        $this->column('o3')->double()->default(0);

        $this->column('aqi')->smallint();

        $this->column('wind_speed')->double();

        $this->column('wind_direction')->double();

        // PublishTime: "2015-03-04 22:00"
        $this->column('published_at')->timestamp()->isa('DateTime')->notNull();

        $this->belongsTo('station', 'App\Model\StationSchema', 'id', 'station_id');
    }
}
