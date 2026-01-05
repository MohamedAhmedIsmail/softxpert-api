<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task)
    {
        return $user->isManager() || $task->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->isManager();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->isManager();
    }

     public function updateStatus(User $user, Task $task): bool
    {
        return $user->isManager() || $task->assigned_to === $user->id;
    }

    public function assign(User $user): bool
    {
        return $user->isManager();
    }

    public function manageDependencies(User $user): bool
    {
        return $user->isManager();
    }
}
