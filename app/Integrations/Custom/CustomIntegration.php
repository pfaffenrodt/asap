<?php


namespace App\Integrations\Custom;

use App\Integrations\BaseIntegration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

class CustomIntegration extends BaseIntegration
{

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

    function fetchReleases(Project $project)
    {
        $headers = [
            "Authorization" => "$project->integration_access_token",
        ];
        return Http::acceptJson()
            ->withHeaders($headers)
            ->get($project->repository)
            ->json();
    }
}
