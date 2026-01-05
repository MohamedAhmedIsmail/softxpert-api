<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDependenciesRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\TaskService;
use Illuminate\Http\Request;



class TaskController extends Controller
{
    public function __construct(private TaskRepositoryInterface $tasks,private TaskService $service) 
    {

    }
    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['sometimes','string'],
            'due_from' => ['sometimes','date'],
            'due_to' => ['sometimes','date'],
            'assigned_to' => ['sometimes','integer','exists:users,id'],
            'per_page' => ['sometimes','integer','min:1','max:100'],
        ]);

        if (!empty($filters['assigned_to']) && !$request->user()->isManager()) 
        {
            return response()->json(['message' => 'Forbidden: cannot filter by assigned user.',], 403);
        }

        $perPage = $filters['per_page'] ?? 15;

        $paginator = $this->tasks->paginateForUser($filters, $request->user(), $perPage);

        return TaskResource::collection($paginator);
    }
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task = $this->tasks->findOrFail($task->id);

        return new TaskResource($task);
    }
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = $this->service->createTask($request->validated());

        return (new TaskResource($task->load(['assignee','dependencies'])))->response()->setStatusCode(201);
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $updated = $this->service->updateTask($task, $request->validated());

        return new TaskResource($updated->load(['assignee','dependencies']));
    }
    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        if (!$request->user()->isManager() && $task->assigned_to !== $request->user()->id) 
        {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $updated = $this->service->updateStatus($task->load('dependencies'), $request->validated()['status']);

        return new TaskResource($updated->load(['assignee','dependencies']));
    }

    public function setDependencies(AddDependenciesRequest $request, Task $task)
    {
        $this->authorize('manageDependencies', $task);

        $dependencyIds = $request->validated()['dependency_task_ids'];

        $updated = $this->service->setDependencies($task, $dependencyIds);

        return new TaskResource($updated);
    }
}
