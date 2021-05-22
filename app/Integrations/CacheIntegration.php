<?php


namespace App\Integrations;


use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class CacheIntegration implements Integration
{
    /**
     * @var Integration $integration
     */
    protected $integration;

    /**
     * @var integer
     */
    protected $cacheTtl;

    /**
     * CacheIntegration constructor.
     * @param int $cacheTtl
     * @param Integration $integration
     */
    public function __construct(int $cacheTtl, Integration $integration)
    {
        $this->integration = $integration;
        $this->cacheTtl = $cacheTtl;
    }


    function provideReleases(Project $project){
        return Cache::remember('releases.'.$project->id,  $this->cacheTtl, function() use ($project) {
            return $this->integration->provideReleases($project);
        });
    }
}
