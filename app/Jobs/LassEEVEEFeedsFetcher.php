<?php

namespace App\Jobs;

use App\Datasource\LassEEVEE;

class LassEEVEEFeedsFetcher extends LassFeedsFetcher
{
    public function feedResource()
    {
        return LassEEVEE::feedResource();
    }

    public function parseFeed(array $raw)
    {
        return LassEEVEE::parse($raw);
    }
}
