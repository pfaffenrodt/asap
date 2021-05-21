<?php


namespace App\Integrations\Custom;


use App\Integrations\Integration;
use App\Integrations\WithReleaseResponseMapper;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

class CustomIntegration implements Integration
{
    use WithReleaseResponseMapper;

    protected $releaseMap = [
        'name'        => 'name',
        'description' => 'description',
        'created_at'  => 'created_at',
        'released_at' => 'released_at',
        'commit'      => 'commit',
        'packages'    => 'packages',
    ];

    protected $packageMap = [
        'name' => 'name',
        'url'  => 'url',
    ];

    function provideReleases(Project $project)
    {
        $access_token = $project->integration_access_token;
        $headers = [
            "Accept" => "application/json",
            "Authorization" => "$access_token",
        ];
        $response = Http::withHeaders($headers)->get($project->repository)->json();
        return $this->mapResponse($response);
    }
}
