<?php

namespace App\Datasource;

use Carbon\Carbon;
use App\Models\Record;

class EpaMicro implements Contract
{
    public static function feedResource()
    {
        $query = [
            '$expand' => 'Thing,Observations($orderby=phenomenonTime desc;$top=1)',
            '$select' => 'name,Thing,Observations',
            '$filter' => "name eq 'PM2.5'",
            '$count' => 'true',
            '$top' => 500,
        ];

        return 'https://sta.ci.taiwan.gov.tw/STA_AirQuality_EPAIoT/v1.0/Datastreams?' . http_build_query($query);
    }

    public static function parseRawData(array $data)
    {
        $nextLink = array_get($data, '@iot.nextLink');

        $values = collect(array_get($data, 'value'))
            ->filter(function ($item) {
                return count(array_get($item, 'Observations', []));
            })
            ->map(function ($item) {
                return [
                    'stationID' => array_get($item, 'Thing.properties.stationID'),
                    'type' => array_get($item, 'name'),
                    'value' => array_get($item, 'Observations.0.result'),
                    'time' => array_get($item, 'Observations.0.phenomenonTime'),
                ];
            })
            ->values()
            ->toArray();

        return compact('nextLink', 'values');
    }

    public static function parse(array $raw)
    {
        return [
            'uuid'          => array_get($raw, 'stationID'),
            'name'          => array_get($raw, 'name'),
            'maker'         => 'EPA-Micro',
            'lat'           => array_get($raw, 'lat'),
            'lng'           => array_get($raw, 'lng'),
            'published_at'  => Carbon::parse(array_get($raw, 'time'))->timezone('UTC'),
            'pm25'          => array_get($raw, 'value'),
            'humidity'      => null,
            'temperature'   => null,
        ];
    }

    public static function getSkipNumber(string $nextLink)
    {
        try {
            $urlInfo = parse_url($nextLink);
            $query = [];
            parse_str($urlInfo['query'], $query);
            return $query['$skip'];
        } catch (\Exception $e) {
            return null;
        }
    }
}
