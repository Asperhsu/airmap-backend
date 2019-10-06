<?php

namespace App\Jobs;

use App\Models\Group;
use App\Datasource\Epa;
use App\Datasource\EpaMicro;
use App\Service\HttpClient;
use Illuminate\Support\Facades\Storage;

class EpaMicroFeedsFetcher extends FeedsFetcher
{
    protected $skip;
    protected $nextLink;
    protected $siteInfoFilename = 'epamicro-sites-info.json';
    protected $siteInfo;
    protected $stationIds;

    public function __construct(Group $group, int $skip = 0)
    {
        parent::__construct($group);

        $this->skip = $skip;
        $this->loadSitesInfo();
    }

    public function loadSitesInfo()
    {
        if (!Storage::exists($this->siteInfoFilename)) {
            throw new \Exception('Site info not exixts');
        }

        $this->siteInfo = collect(json_decode(Storage::get($this->siteInfoFilename), true));
        $this->stationIds = $this->siteInfo->pluck('stationID')->toArray();
    }

    public function feedResource()
    {
        $url = EpaMicro::feedResource();
        if ($this->skip > 0) {
            $url .= '&$skip=' . $this->skip;
        }
        return $url;
    }

    public function filter(array $raw)
    {
        return in_array(array_get($raw, 'stationID'), $this->stationIds);
    }

    public function feeds(array $data)
    {
        $data = EpaMicro::parseRawData($data);

        $this->nextLink = $data['nextLink'];

        return $data['values'];
    }

    public function parseFeed(array $raw)
    {
        $stationId = array_get($raw, 'stationID');
        $info = $this->siteInfo->where('stationID', $stationId)->first() ?? [];
        $row = array_merge($raw, $info);

        return EpaMicro::parse($row);
    }

    public function handle()
    {
        parent::handle();

        if ($this->nextLink && ($skip = EpaMicro::getSkipNumber($this->nextLink))) {
            $job = new static($this->group, $skip);
            dispatch($job);
        }
    }
}
