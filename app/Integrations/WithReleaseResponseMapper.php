<?php


namespace App\Integrations;


use Illuminate\Support\Arr;

trait WithReleaseResponseMapper
{

    protected function mapData(array $input, $map)
    {
        $output = [];
        foreach ($map as $attribute => $inputKey) {
            if (is_array($inputKey)) {
                $output[$attribute] = $this->mapData($input, $inputKey);
            } elseif (is_string($inputKey)) {
                $output[$attribute] = Arr::get($input, $inputKey, '');
            }
        }

        return $output;
    }

    function mapResponse(array $response)
    {
        return collect($response)->map(function ($release) {
            $release = $this->mapData($release, $this->releaseMap);
            $release['packages'] = $this->mapData($release['packages'], $this->packageMap);
            return $release;
        });
    }
}
