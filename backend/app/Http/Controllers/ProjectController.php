<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
   public function indexAdmin()
{
    // Admin can see ALL projects with more data if needed
    return ProjectResource::collection(
        Project::with('user')->latest()->paginate(15)
    );
}

    /**
     * GET /api/projects
     * List all projects with filtering, sorting and pagination.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // FILTER BY STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SEARCH FILTER
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // SORTING
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if ($sort === 'name') {
            // Case-insensitive sort for name
            $query->orderByRaw("LOWER(name) $direction");
        } else {
            $query->orderBy($sort, $direction);
        }

        // PAGINATION
        $limit = $request->get('limit', 10);
        $projects = $query->paginate($limit);

        return ProjectResource::collection($projects)->additional([
            'meta' => [
                'success' => true,
                'filters' => $request->all(),

                // CLEAN PAGINATION METADATA
                'pagination' => [
                    'total'        => $projects->total(),
                    'per_page'     => $projects->perPage(),
                    'current_page' => $projects->currentPage(),
                    'last_page'    => $projects->lastPage(),
                ],
            ],
        ]);
    }

    /**
     * POST /api/projects
     * Create a new project.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $project = Project::create($validated);

        return new ProjectResource($project);
    }

    /**
     * GET /api/projects/{project}
     * Show a single project.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return new ProjectResource($project);
    }

    /**
     * PUT /api/projects/{project}
     * Update a project.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return new ProjectResource($project);
    }

    /**
     * DELETE /api/projects/{project}
     * Delete a project.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
