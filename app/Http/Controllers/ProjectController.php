<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
            'exampleRepository' => Config::get('app.example_repository_url'),
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
        $user->currentTeam->projects()->create(
            request()->validate([
                'name'       => 'required',
                'repository' => 'url',
                'integration_type' => ['string', Rule::in(Config::get('app.integration_types'))],
                'integration_access_token' => 'string',
            ])
        );

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
            'releases' => [
                [
                    'name' => 'Release 1.0.2',
                    'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
                    'packages' => [
                        [
                            'name' => 'Android Apk',
                            'url' => 'https://test',
                        ],
                        [
                            'name' => 'IOS IPA',
                            'url' => 'https://test',
                        ],
                    ],
                ],
                [
                    'name' => 'Release 1.0.1',
                    'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
                    'packages' => [
                        [
                            'name' => 'Android Apk',
                            'url' => 'https://test',
                        ],
                        [
                            'name' => 'IOS IPA',
                            'url' => 'https://test',
                        ],
                    ],
                ],
                [
                    'name' => 'Release 1.0.0',
                    'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
                    'packages' => [
                        [
                            'name' => 'Android Apk',
                            'url' => 'https://test',
                        ],
                        [
                            'name' => 'IOS IPA',
                            'url' => 'https://test',
                        ],
                    ],
                ],
            ],
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
            'project' => $project->setAppends(['has_integration_access_token']),
            'exampleRepository' => Config::get('app.example_repository_url'),
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
        $project->update(
            $this->validate($request, [
                'name'       => 'string',
                'repository' => 'url',
                'integration_type' => ['string', Rule::in(Config::get('app.integration_types'))],
                'integration_access_token' => 'string',
            ])
        );
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
