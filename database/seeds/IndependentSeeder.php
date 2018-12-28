<?php

use Illuminate\Database\Seeder;

use App\Models\Group;
use App\Models\Thingspeak;

class IndependentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = Group::where('name', 'Independent')->first();

        $sites = [
            [
                'channel'       => 106666,
                'party'         => 'CCU NEAT',
                'maker'         => '林俊翰',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field3',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 298800,
                'party'         => 'Freeman Lee',
                'maker'         => 'Freeman Lee',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field4',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 386921,
                'party'         => 'NCHUEE510A',
                'maker'         => '區志杰',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field4',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 393872,
                'party'         => 'Sun-Xiede Air',
                'maker'         => 'KennethSun',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field1',
                    'humidity'      => 'field3',
                    'temperature'   => 'field2',
                ],
            ],
            [
                'channel'       => 216017,
                'party'         => '國立台北科技大學',
                'maker'         => '江思賢',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field4',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 395070,
                'party'         => 'CYTech',
                'maker'         => 'Haur',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field4',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 73772,
                'party'         => 'elhomeo168',
                'maker'         => 'kadela',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field3',
                    'humidity'      => 'field2',
                    'temperature'   => 'field6',
                ],
            ],
            [
                'channel'       => 393056,
                'party'         => 'Duzihtou',
                'maker'         => 'FormosaFox',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field1',
                    'humidity'      => 'field3',
                    'temperature'   => 'field2',
                ],
            ],
            [
                'channel'       => 407186,
                'party'         => 'LunAirBox',
                'maker'         => 'Lun',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field3',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 413566,
                'party'         => 'Tracker99ECO',
                'maker'         => 'jimmy.su',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field3',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 442189,
                'party'         => 'NKUST_EC_AIRBOX',
                'maker'         => 'Larry_Chiou.su',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field4',
                    'humidity'      => 'field2',
                    'temperature'   => 'field1',
                ],
            ],
            [
                'channel'       => 566989,
                'party'         => 'Outdoor2018',
                'maker'         => 'walkman.yen',
                'active'        => true,
                'fields_map'    => [
                    'pm25'          => 'field2',
                    'humidity'      => 'field4',
                    'temperature'   => 'field3',
                ],
            ],
        ];

        foreach ($sites as $site) {
            Thingspeak::create([
                'channel'     => $site['channel'],
                'party'       => $site['party'],
                'maker'       => $site['maker'],
                'fields_map'  => collect($site['fields_map']),
                'active'      => isset($site['active']) ? $site['active'] : true,
                'group_id'    => $group->id,
            ]);
        }
    }
}
