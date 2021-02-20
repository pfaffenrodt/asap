<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->belongsToTeam($user->currentTeam);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $user->belongsToTeam($project->team);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $user->hasTeamPermission($project->team, 'project:update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->hasTeamPermission($project->team, 'project:delete');
    }
}
