<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Repository\JSONRepository;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $countries = $towns = $sites = [];
        $country = $request->get('country');
        $town = $request->get('town');
        $keyword = $request->get('keyword');

        $geometrySrv = resolve('App\Service\Geometry');
        ['countries' => $countries, 'towns' => $towns] = $geometrySrv->countryTowns();

        if ($keyword) {
            $sites = JSONRepository::groups()->filter(function ($record) use ($keyword) {
                return strpos(strtolower($record->get('SiteName')), strtolower($keyword)) !== false;
            });
        }

        if (!$keyword && $country && $town) {
            $sites = JSONRepository::groups()->filter(function ($record) use ($country, $town) {
                return $record->get('Geometry')
                    && ($record->get('Geometry')->get('COUNTYCODE') === $country)
                    && ($town == 'all' ? true : $record->get('Geometry')->get('TOWNCODE') === $town);
            });
        }

        return view('list', compact('countries', 'towns', 'sites', 'country', 'town', 'keyword'));
    }
}
