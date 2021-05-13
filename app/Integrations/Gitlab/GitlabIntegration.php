<?php


namespace App\Integrations\Gitlab;


use App\Integrations\Integration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class GitlabIntegration implements Integration
{
    function provideReleases(Project $project)
    {
        // https://docs.gitlab.com/ee/user/project/releases/
        // api to list https://docs.gitlab.com/ee/api/releases/index.html#list-releases
        $repositoryUrlData = parse_url($project->repository);
        $host = $repositoryUrlData['host'];
        $access_token = $project->integration_access_token;
        $projects = Http::withHeaders(["PRIVATE-TOKEN" => $access_token])
            ->get("https://$host/api/v4/projects?simple=1&".$repositoryUrlData['path'])
            ->json();
        $remoteProject = collect($projects)->first(function($remoteProject) use ($project) {
            return $remoteProject['web_url'] === $project->repository;
        });
        $id = $remoteProject['id'];
        return collect(Http::withHeaders(["PRIVATE-TOKEN" => $access_token])
            ->get("https://$host/api/v4/projects/$id/releases")
            ->json())->map(function($release) {
                return [
                    'name' => $release['name'] ?? '',
                    'description' => $release['name'] ?? '',
                    'created_at' => $release['created_at'] ?? '',
                    'released_at' => $release['released_at'] ?? '',
                    'commit' => $release['commit']['short_id'] ?? '',
                    'packages' => collect($release['assets']['links'])->map(function($package) {
                        return [
                            'name' => $package['name'],
                            'url' => $package['direct_asset_url'],
                        ];
                    })
                ];
        });
    }

}
