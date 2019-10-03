<?php

namespace App\Jobs;

use App\Datasource\LassMAPS;

class LassMAPSFeedsFetcher extends LassFeedsFetcher
{
    public function feedResource()
    {
        return LassMAPS::feedResource();
    }

    public function parseFeed(array $raw)
    {
        return LassMAPS::parse($raw);
    }
}
