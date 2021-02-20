<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $projects = $user->currentTeam->projects;
        if ($projects->isEmpty() && $user->can('create', \App\Models\Project::class)) {
            return Redirect::route('projects.create');
        }
        return Inertia::render('Projects/Index', [
            'permissions' => [
                'canCreateProject' => $user->can('create', \App\Models\Project::class),
            ],
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        return Inertia::render('Projects/Create', [
            'permissions' => [
                'canCreateProject' => $user->can('create', \App\Models\Project::class),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->currentTeam->projects()->create(request()->validate(['name' => 'required']));

        return Redirect::route('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show(Project $project)
    {
        return  Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Inertia\Response
     */
    public function edit(Project $project)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        return  Inertia::render('Projects/Edit', [
            'permissions' => [
                'canUpdateProject' => $user->can('update', $project),
                'canDeleteProject' => $user->can('delete', $project),
            ],
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $newData = $this->validate($request, [
            'name' => 'string',
        ]);
        $project->update($newData);
        return Redirect::route('projects.edit', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return Redirect::route('projects');
    }

}
