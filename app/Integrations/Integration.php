<?php


namespace App\Integrations;


use App\Models\Project;

interface Integration
{
    function provideReleases(Project $project);
}
