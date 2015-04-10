<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class MeasureSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('station_id')->mediumint()->notNull();

        $this->column('pm10')->double()->default(0);

        $this->column('pm25')->double()->default(0);

        $this->column('no2')->double()->default(0);

        $this->column('fpmi')->double()->default(0);

        $this->column('so2')->double()->default(0);

        $this->column('co')->double()->default(0);

        $this->column('o3')->double()->default(0);

        $this->column('psi')->double()->default(0);

        $this->column('aqi')->integer();

        $this->column('status_text')->double()->default(0);

        $this->column('wind_speed')->double();

        $this->column('wind_direction')->double();

        $this->column('major_pollutant')->varchar(32);

        // PublishTime: "2015-03-04 22:00"
        $this->column('published_at')->timestamp()->isa('DateTime')->notNull();

        $this->belongsTo('station', 'PM25\Model\StationSchema', 'id', 'station_id');
    }
}
