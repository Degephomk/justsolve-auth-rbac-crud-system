<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;

class AdminController extends Controller
{
    /**
     * ADMIN: List all projects in the system.
     * Unlike regular users, admins can see all projects.
     */
    public function index()
    {
        $projects = Project::with('user')->latest()->paginate(20);

        return ProjectResource::collection($projects)->additional([
            'meta' => [
                'success' => true,
                'admin' => true,
            ],
        ]);
    }
}
