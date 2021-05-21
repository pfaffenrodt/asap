<?php


namespace App\Integrations\Github;


use App\Integrations\Integration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

class GithubIntegration implements Integration
{
    function provideReleases(Project $project)
    {
        // https://docs.github.com/en/rest/reference/repos#releases
        $access_token = $project->integration_access_token;
        $projectPath = $project->path;
        return collect(Http::accept("application/vnd.github.v3+json")
            ->withToken($access_token, 'token')
            ->get("https://api.github.com/repos$projectPath/releases")
            ->json())->map(function($release) {
            return [
                'name' => $release['name'] ?? '',
                'description' => $release['body'] ?? '',
                'created_at' => $release['created_at'] ?? '',
                'released_at' => $release['published_at'] ?? '',
                'commit' => '',
                'packages' => collect($release['assets'])->map(function($package) {
                    return [
                        'name' => $package['name'],
                        'url' => $package['browser_download_url'],
                    ];
                }),
            ];
        });
    }

}
