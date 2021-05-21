<?php


namespace App\Integrations\Github;


use App\Integrations\Integration;
use App\Integrations\WithReleaseResponseMapper;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

/**
 * integration for release api of github
 * https://docs.github.com/en/rest/reference/repos#releases
 */
class GithubIntegration implements Integration
{
    use WithReleaseResponseMapper;

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


    function provideReleases(Project $project)
    {
        $access_token = $project->integration_access_token;
        $projectPath = $project->path;
        $response = Http::accept("application/vnd.github.v3+json")
            ->withToken($access_token, 'token')
            ->get("https://api.github.com/repos$projectPath/releases")
            ->json();
        return $this->mapResponse($response);
    }
}
