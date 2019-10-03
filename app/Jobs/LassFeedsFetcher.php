<?php

namespace App\Jobs;

use App\Datasource\Lass;
use App\Service\HttpClient;
use App\Models\Fetch;

class LassFeedsFetcher extends FeedsFetcher
{
    public function feedResource()
    {
        return Lass::feedResource();
    }

    public function parseFeed(array $raw)
    {
        return Lass::parse($raw);
    }

    public function feeds(array $data)
    {
        return array_get($data, 'feeds', []);
    }

    /** overwrite */
    protected function fetch(string $url)
    {
        $response = $this->processJsonGz($url);

        $feeds = $this->feeds($response['data']);

        $this->fetch = Fetch::create([
            'group_id' => $this->group->id,
            'transfer_ms' => $response['status']['transferTime'],
            'feeds' => count($feeds),
        ]);

        return is_array($feeds) ? $feeds : [];
    }

    protected function processJsonGz(string $url)
    {
        if (!is_dir($directoryName = storage_path('tmp'))) {
            mkdir($directoryName, 0755);
        }

        $gzFilePath = $directoryName . '/' . basename($url);
        $response = HttpClient::download($url, $gzFilePath);
        $response['data'] = [];

        if ($response['success'] === false) {
            return $response;
        }

        try {
            $json = implode('', gzfile($gzFilePath));
            $data = json_decode($json, true);
            $response['data'] = $data;
            unlink($gzFilePath);
        } catch (\Exception $e) {
            //
        }
        return $response;
    }
}
