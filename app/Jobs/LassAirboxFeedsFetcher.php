<?php

namespace App\Jobs;

use App\Datasource\LassAirbox;

class LassAirboxFeedsFetcher extends LassFeedsFetcher
{
    public function feedResource()
    {
        return LassAirbox::feedResource();
    }

    public function parseFeed(array $raw)
    {
        return LassAirbox::parse($raw);
    }
}
