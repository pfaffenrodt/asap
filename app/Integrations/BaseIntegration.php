<?php


namespace App\Integrations;


use App\Models\Project;
use Illuminate\Support\Arr;

abstract class BaseIntegration implements Integration
{
    protected $releaseMap = [];
    protected $packageMap = [];

    private function mapData(array $input, $map)
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

    protected function mapResponse(array $response)
    {
        return collect($response)->map(function ($release) {
            $release = $this->mapData($release, $this->releaseMap);
            $release['packages'] = $this->mapData($release['packages'], $this->packageMap);
            return $release;
        });
    }

    function provideReleases(Project $project)
    {
        return $this->mapResponse($this->fetchReleases($project));
    }

    abstract function fetchReleases(Project $project);
}
