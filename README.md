# PM25 Data Collector

## Setup

```
composer install --prefer-source

ln -s database.dev.yml config/database.yml
ln -s framework.dev.yml config/framework.yml

php vendor/bin/lazy build-conf config/database.yml
php vendor/bin/phifty bootstrap
php vendor/bin/lazy schema build
```

## Data Source

- http://opendata.epa.gov.tw/Data/Contents/PM25/
