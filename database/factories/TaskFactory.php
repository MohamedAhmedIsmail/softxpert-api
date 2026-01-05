<?php

namespace Database\Factories;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'assigned_to' => User::factory(),
            'due_date' => optional(fake()->optional()->dateTimeBetween('now', '+30 days'))->format('Y-m-d'),
            'status' => fake()->randomElement(TaskStatus::values()),
        ];
    }
}
