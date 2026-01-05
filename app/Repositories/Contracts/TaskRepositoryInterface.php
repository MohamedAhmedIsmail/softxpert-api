<?php

namespace App\Repositories\Contracts;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;
    public function update(Task $task, array $data): Task;
    public function findOrFail(int $id): Task;

    public function paginateForUser(array $filters, \App\Models\User $user, int $perPage = 15): LengthAwarePaginator;

    public function syncDependencies(Task $task, array $dependencyIds): Task;
}
