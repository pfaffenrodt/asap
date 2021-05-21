<?php


namespace App\Integrations\Custom;


use App\Integrations\Integration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;

class CustomIntegration implements Integration
{
    function provideReleases(Project $project)
    {
        $access_token = $project->integration_access_token;
        $headers = [
            "Accept" => "application/json",
            "Authorization" => "$access_token",
        ];
        return collect(
            Http::withHeaders($headers)->get($project->repository)->json()
        )->map(function($release) {
            return [
                'name' => $release['name'] ?? '',
                'description' => $release['description'] ?? '',
                'created_at' => $release['created_at'] ?? '',
                'released_at' => $release['published_at'] ?? '',
                'commit' => $release['commit'] ?? '',
                'packages' => collect($release['packages'])->map(function($package) {
                    return [
                        'name' => $package['name'],
                        'url' => $package['url'],
                    ];
                }),
            ];
        });
    }

}
