<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function __construct(private TaskRepositoryInterface $tasks) {}

    public function createTask(array $data): Task
    {
        return $this->tasks->create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->tasks->update($task, $data);
    }

    public function updateStatus(Task $task, string $status): Task
    {
        if ($status === TaskStatus::Completed->value) 
        {
            $incompleteDeps = $task->dependencies()->where('status', '!=', TaskStatus::Completed->value)->count();

            if ($incompleteDeps > 0) 
            {
                throw ValidationException::withMessages([
                    'status' => ['Task cannot be completed until all dependencies are completed.'],
                ]);
            }
        }

        return $this->tasks->update($task, ['status' => $status]);
    }

    public function setDependencies(Task $task, array $dependencyIds): Task
    {
        if (in_array($task->id, $dependencyIds, true)) 
        {
            throw ValidationException::withMessages([
                'dependency_task_ids' => ['Task cannot depend on itself.'],
            ]);
        }

        //prevent making cycle or circle of dependencies
        // Task A → Task B → Task C 
        // this not accepted Task A → Task C → Task B → Task A
        $wouldCreateCycle = Task::query()->whereIn('id', $dependencyIds)->whereHas('dependencies', fn($q) => $q->where('tasks.id', $task->id))->exists();

        if ($wouldCreateCycle) 
        {
            throw ValidationException::withMessages([
                'dependency_task_ids' => ['Dependency cycle detected.'],
            ]);
        }

        return $this->tasks->syncDependencies($task, $dependencyIds);
    }
}
