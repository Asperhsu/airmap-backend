<?php

use Illuminate\Database\Seeder;

use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name'    => 'LASS',
                'handler' => 'App\Jobs\LassFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'LASS-4U',
                'handler' => 'App\Jobs\Lass4UFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'LASS-MAPS',
                'handler' => 'App\Jobs\LassMAPSFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'LASS-EEVEE',
                'handler' => 'App\Jobs\LassEEVEEFeedsFetcher',
                'enable'  => false,
            ],
            [
                'name'    => 'LASS-Airbox',
                'handler' => 'App\Jobs\LassAirboxFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'Asus',
                'handler' => 'App\Jobs\AsusFeedsFetcher',
                'enable'  => false,
            ],
            [
                'name'    => 'Probecube',
                'handler' => 'App\Jobs\ProbecubeFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'Independent',
                'handler' => 'App\Jobs\IndependentFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'EPA',
                'handler' => 'App\Jobs\EpaFeedsFetcher',
                'enable'  => false,
            ],
            [
                'name'    => 'Airq',
                'handler' => 'App\Jobs\AirqFeedsFetcher',
                'enable'  => true,
            ],
            [
                'name'    => 'EPA-Micro',
                'handler' => 'App\Jobs\EpaMicroFeedsFetcher',
                'enable'  => true,
            ],
        ];

        foreach ($groups as $group) {
            Group::create($group);
        }
    }
}
