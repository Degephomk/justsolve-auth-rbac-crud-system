<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Anyone authenticated can view any project.
     * (Admin OR User)
     */
    public function view(User $user, Project $project): bool
    {
        return true;
    }

    /**
     * Anyone authenticated can list projects.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Anyone can create a project (user or admin).
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Update only if:
     * - user is ADMIN
     * - OR user is OWNER
     */
    public function update(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->user_id;
    }

    /**
     * Delete only if:
     * - user is ADMIN
     * - OR user is OWNER
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->user_id;
    }
}
