<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tasks = Project::all();
        return [
            "name" => fake()->text(50),
            "description" => fake()->text(200),
            "hours" => fake()->numberBetween(10, 25).":".(fake()->boolean() ? "00" : "30"),
            "progress_hours" => "0".fake()->numberBetween(0, 2).":".fake()->numberBetween(10, 59),
            "project_id" => 1,
        ];
    }
}
