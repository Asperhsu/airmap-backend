<?php

namespace App\Datasource;

class LassMAPS extends Lass
{
    public static $maker = 'LASS-MAPS';

    public static function feedResource()
    {
        return 'https://data.lass-net.org/data/last-all-maps.json.gz';
    }
}
