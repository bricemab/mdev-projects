<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReportFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tasks = Task::all();
        $users = User::all();
        return [
            "description" => fake()->text(),
            "time" => "0".fake()->numberBetween(0, 3).":".fake()->randomElement(["05", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55"]),
            "date" => date("Y-m-d H:i:s"),
            "user_id" => $tasks[fake()->numberBetween(0, count($users) - 1)]->id,
            "task_id" => $tasks[fake()->numberBetween(0, count($tasks) - 1)]->id,
            "project_id" => $tasks[0]->project_id
        ];
    }
}
