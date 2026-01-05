<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        Task::factory()->count(10)->create([
            'assigned_to' => $users->random()->id,
        ]);

        $t1 = Task::factory()->create(['assigned_to' => $users->first()->id, 'status' => 'pending']);
        $t2 = Task::factory()->create(['assigned_to' => $users->first()->id, 'status' => 'pending']);

        $t2->dependencies()->sync([$t1->id]);
    }
}
