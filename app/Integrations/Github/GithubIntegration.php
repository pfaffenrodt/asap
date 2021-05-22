<?php


namespace App\Integrations\Github;

use App\Integrations\BaseIntegration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

/**
 * integration for release api of github
 * https://docs.github.com/en/rest/reference/repos#releases
 */
class GithubIntegration extends BaseIntegration
{

    protected $releaseMap = [
        'name'        => 'name',
        'description' => 'body',
        'created_at'  => 'created_at',
        'released_at' => 'published_at',
//        'commit'      => '',
        'packages'    => 'assets',
    ];

    protected $packageMap = [
        'name' => 'name',
        'url'  => 'browser_download_url',
    ];


    function fetchReleases(Project $project)
    {
        $access_token = $project->integration_access_token;
        $projectPath = $project->path;
        return Http::accept("application/vnd.github.v3+json")
            ->withToken($access_token, 'token')
            ->get("https://api.github.com/repos$projectPath/releases")
            ->json();
    }
}
