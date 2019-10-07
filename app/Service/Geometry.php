<?php

namespace App\Service;

use Geometry\Polygon;
use Illuminate\Support\Collection;

class Geometry
{
    protected $features;
    protected $geoJsonPath = 'assets/json/town.json';
    protected $towncodeIndexMapping;

    public function __construct()
    {
        $this->loadGeojson();
    }

    public function loadGeojson()
    {
        $path = resource_path($this->geoJsonPath);

        if (!file_exists($path)) {
            throw new \RuntimeException($this->geoJsonPath . ' is not found.');
        }

        $json = json_decode(file_get_contents($path), true);

        if (!isset($json['features'])) {
            throw new \RuntimeException('features is not found.');
        }

        $this->features = $json['features'];
    }

    public function getFeatureByTownID(string $townCode)
    {
        if (!$this->towncodeIndexMapping) {
            $this->towncodeIndexMapping = collect($this->features)->mapWithKeys(function ($feature, $index) {
                return [array_get($feature, 'properties.TOWNCODE') => $index];
            });
        }

        $index = array_get($this->towncodeIndexMapping, $townCode);
        return $index ? $this->features[$index] : null;
    }

    public function findFeature(float $lat, float $lng)
    {
        return collect($this->features)
            ->filter(function ($feature) use ($lat, $lng) {
                $coordinates = array_get($feature, 'geometry.coordinates.0');
                if (!$coordinates) {
                    return false;
                }

                return $this->isInPolygon($coordinates, $lat, $lng);
            })->first();
    }

    public function isInPolygon(array $coordinates, float $lat, float $lng)
    {
        $poly = new Polygon($coordinates);

        return $poly->pip($lng, $lat);
    }

    public static function boxplot(Collection $records)
    {
        $values = $records->values()->toArray();
        $quartiles  = \MathPHP\Statistics\Descriptive::quartiles($values);
        $outlinerMin = $quartiles['Q1'] - $quartiles['IQR'] * 1.5;  // Q1-1.5ΔQ
        $outlinerMax = $quartiles['Q3'] + $quartiles['IQR'] * 1.5;  // Q3+1.5ΔQ

        $valids = collect();
        $outliners = collect();
        $validValues = [];
        $records->map(function ($value, $key) use ($outlinerMin, $outlinerMax, &$valids, &$outliners, &$validValues) {
            // valid value should be: Q1-1.5ΔQ < value < Q3+1.5ΔQ
            $isOutliner = ($value < $outlinerMin) || ($value > $outlinerMax);

            if ($isOutliner) {
                $outliners->push($key);
            } else {
                $valids->push($key);
                $validValues[] = $value;
            }
        });

        return [
            'mean' => \MathPHP\Statistics\Average::mean($validValues),
            'valids' => $valids,
            'outliners' => $outliners,
        ];
    }

    public function countryTowns()
    {
        $countries = [];
        $towns = [];

        foreach ($this->features as $feature) {
            $countryCode = (string) $feature['properties']['COUNTYCODE'];
            $countryName = $feature['properties']['COUNTYNAME'];
            $townCode = (string) $feature['properties']['TOWNCODE'];
            $townName = $feature['properties']['TOWNNAME'];

            $countries[$countryCode] = $countryName;
            $towns[$countryCode][] = [
                'code' => $townCode,
                'name' => $townName,
            ];
        }

        ksort($countries);
        ksort($towns);

        return compact('countries', 'towns');
    }
}
