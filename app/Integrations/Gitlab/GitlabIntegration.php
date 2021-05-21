<?php


namespace App\Integrations\Gitlab;


use App\Integrations\Integration;
use App\Models\Project;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class GitlabIntegration implements Integration
{

    function provideReleases(Project $project)
    {
        // https://docs.gitlab.com/ee/user/project/releases/
        // api to list https://docs.gitlab.com/ee/api/releases/index.html#list-releases
        $host = $project->host;
        $id = $this->searchProjectId($project);
        return collect($this->createAuthorizedRequest($project)
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

    protected function createAuthorizedRequest(Project $project): PendingRequest {
        return Http::withHeaders(["PRIVATE-TOKEN" => $project->integration_access_token]);
    }

    protected function searchProjectId(Project $project) {
        $host = $project->host;
        $projects = $this->createAuthorizedRequest($project)
            ->get("https://$host/api/v4/projects?simple=1&".$project->path)
            ->json();
        $remoteProject = collect($projects)->first(function($remoteProject) use ($project) {
            return $remoteProject['web_url'] === $project->repository;
        });
        return $remoteProject['id'] ?? abort(404);
    }
}
