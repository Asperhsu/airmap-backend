<?php

namespace App\Console\Commands;

use App\Jobs\LassAnalysisFetcher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Service\HttpClient;

class FetchEpaMicroLocations extends Command
{
    protected $signature = 'fetch:epa-micro-locations';
    protected $description = 'fetch EPA Micro Locations';

    protected $filename = 'epamicro-sites-info.json';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $things = [];

        $url = $this->getUrl();
        while ($url) {
            $response = HttpClient::getJson($url);
            $data = $this->parseRespnse($response);
            $things = array_merge($things, $data['values']);

            if ($data['nextLink']) {
                $skip = $this->getSkipNumber($data['nextLink']);
                $url = $skip ? $this->getUrl($skip) : null;
                $this->line($skip . ' fetched');
            } else {
                break;
            }
        }

        $this->info('total things count: ' . count($things));
        Storage::put($this->filename, json_encode($things));
    }

    protected function getUrl(int $skip = null)
    {
        $query = [
            '$expand' => 'Locations',
            '$select' => 'name,properties',
            '$top' => 500,
        ];

        if (!is_null($skip) && $skip > 0) {
            $query['$skip'] = $skip;
        }

        return 'https://sta.ci.taiwan.gov.tw/STA_AirQuality_EPAIoT/v1.0/Things?' . http_build_query($query);
    }

    protected function parseRespnse(array $response)
    {
        $nextLink = array_get(array_get($response, 'data', []), '@iot.nextLink');

        $values = collect(array_get($response, 'data.value'))->map(function ($item) {
            $areaType = array_get($item, 'properties.areaType');
            $areaDesc = array_get($item, 'properties.areaDescription');
            $stationName = array_get($item, 'properties.stationName');

            return [
                'name' => implode(':', array_filter([$areaType, $areaDesc, $stationName])),
                'stationID' => array_get($item, 'properties.stationID'),
                'lat' => array_get($item, 'Locations.0.location.coordinates.1'),
                'lng' => array_get($item, 'Locations.0.location.coordinates.0'),
            ];
        })->toArray();

        return compact('nextLink', 'values');
    }

    protected function getSkipNumber(string $nextLink)
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
