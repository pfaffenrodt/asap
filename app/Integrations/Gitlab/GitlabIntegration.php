<?php


namespace App\Integrations\Gitlab;


use App\Integrations\Integration;
use App\Integrations\WithReleaseResponseMapper;
use App\Models\Project;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * integration for release api of gitlab
 * https://docs.gitlab.com/ee/user/project/releases/
 * api to list https://docs.gitlab.com/ee/api/releases/index.html#list-releases
 */
class GitlabIntegration implements Integration
{
    use WithReleaseResponseMapper;

    protected $releaseMap = [
        'name'        => 'name',
        'description' => 'name',
        'created_at'  => 'created_at',
        'released_at' => 'released_at',
        'commit'      => 'commit.short_id',
        'packages'    => 'assets.links',
    ];

    protected $packageMap = [
        'name' => 'name',
        'url'  => 'direct_asset_url',
    ];

    function provideReleases(Project $project)
    {
        $id = $this->searchProjectId($project);
        $host = $project->host;
        $response = $this->createAuthorizedRequest($project)
            ->get("https://$host/api/v4/projects/$id/releases")
            ->json();
        return $this->mapResponse($response);
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
