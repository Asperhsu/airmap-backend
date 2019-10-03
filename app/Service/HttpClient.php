<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class HttpClient
{
    public static function getOptions(array &$status = [], array $options = [])
    {
        return array_merge([
            'on_stats' => function (TransferStats $stats) use (&$status) {
                $status['transferTime'] = $stats->getTransferTime() * 1000;
                $status['effectiveUri'] = $stats->getEffectiveUri();

                if ($stats->hasResponse()) {
                    $status['httpCode'] = $stats->getResponse()->getStatusCode();
                }
            }
        ], $options);
    }

    public static function getJson($url)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $success = false;
        $status = [];
        $data = [];
        $options = static::getOptions($status);

        try {
            $response = $client->request('GET', $url, $options);
            $data = json_decode((string) $response->getBody(), true);
            $success = true;
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $status['httpCode'] = $response->getStatusCode();
            logger('HttpClient::getJson ServerException', (array) $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $status['httpCode'] = $response->getStatusCode();
            }
            logger('HttpClient::getJson RequestException', (array) $e);
        }

        return [
            'success' => $success,
            'status' => $status,
            'data' => $data,
        ];
    }

    public static function download($url, $output)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $success = false;
        $status = [];
        $options = static::getOptions($status, [
            'sink' => $output,
        ]);

        try {
            $response = $client->request('GET', $url, $options);
            $success = true;
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $status['httpCode'] = $response->getStatusCode();
            logger('HttpClient::download ServerException', (array) $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $status['httpCode'] = $response->getStatusCode();
            }
            logger('HttpClient::download RequestException', (array) $e);
        }

        return [
            'success' => $success,
            'status' => $status,
        ];
    }
}
