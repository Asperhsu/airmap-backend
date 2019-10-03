<?php

namespace App\Jobs;

use App\Datasource\Lass4U;

class Lass4UFeedsFetcher extends LassFeedsFetcher
{
    public function feedResource()
    {
        return Lass4U::feedResource();
    }

    public function parseFeed(array $raw)
    {
        return Lass4U::parse($raw);
    }
}
