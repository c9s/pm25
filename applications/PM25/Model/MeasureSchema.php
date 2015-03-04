<?php
namespace PM25\Model;
use LazyRecord\Schema\SchemaDeclare;

class MeasureSchema extends SchemaDeclare
{
    public function schema() {
        $this->column('site_id')->integer();

        $this->column('pm10')->double()->default(0);

        $this->column('pm25')->double()->default(0);

        $this->column('no2')->double()->default(0);

        $this->column('fpmi')->double()->default(0);

        $this->column('so2')->double()->default(0);

        $this->column('c0')->double()->default(0);

        $this->column('psi')->double()->default(0);

        $this->column('status_text')->double()->default(0);

        $this->column('wind_speed')->double();

        $this->column('wind_direction')->double();

        // PublishTime: "2015-03-04 22:00"
        $this->column('published_at')->timestamp();

        $this->belongsTo('site', 'PM25\Model\SiteSchema', 'id', 'site_id');
    }
}
