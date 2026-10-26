<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\ActivityLog;

class ProjectObserver
{
    public function created(Project $project)
    {
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id'    => auth()->id(),
            'action'     => 'created',
        ]);
    }

    public function updated(Project $project)
    {
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id'    => auth()->id(),
            'action'     => 'updated',
        ]);
    }

    // 🔥 Log BEFORE delete (NOT after)
    public function deleting(Project $project)
    {
        ActivityLog::create([
            'project_id' => $project->id,  // ✔ still available
            'user_id'    => auth()->id() ?? 0, // ✔ avoid null
            'action'     => 'deleted',
        ]);
    }

    // ❌ disable: after deleting, model ID may be null
    public function deleted(Project $project)
    {
        // intentionally empty
    }
}
