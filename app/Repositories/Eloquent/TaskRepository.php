<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->fill($data)->save();
        return $task->refresh();
    }

    public function findOrFail(int $id): Task
    {
        return Task::with(['assignee', 'dependencies'])->findOrFail($id);
    }

    public function paginateForUser(array $filters, User $user, int $perPage = 15): LengthAwarePaginator
    {
        $q = Task::query()->with(['assignee', 'dependencies']);

        if (!$user->isManager()) 
        {
            $q->where('assigned_to', $user->id);
        }

        if (!empty($filters['status'])) 
        {
            $q->where('status', $filters['status']);
        }

        if (!empty($filters['assigned_to'])) 
        {
            $q->where('assigned_to', $filters['assigned_to']);
        }

        if (!empty($filters['due_from'])) 
        {
            $q->whereDate('due_date', '>=', $filters['due_from']);
        }

        if (!empty($filters['due_to'])) 
        {
            $q->whereDate('due_date', '<=', $filters['due_to']);
        }

        return $q->orderByDesc('id')->paginate($perPage);
    }

    public function syncDependencies(Task $task, array $dependencyIds): Task
    {
        $task->dependencies()->sync($dependencyIds);
        return $task->refresh()->load(['assignee', 'dependencies']);
    }
}
