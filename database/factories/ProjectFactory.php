<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\File;
use App\ProjectStateEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rate = fake()->numberBetween(50, 100);
        $hours = fake()->numberBetween(50, 500);
        return [
            'name' => fake()->name(),
            "url_prod" => fake()->url(),
            "url_preprod" => fake()->url(),
            "price" => $rate * $hours,
            "hours" => $hours,
            "rate" => $rate,
            "state" => ProjectStateEnum::PENDING->value,
            "file_id" => 1,
            "start_date" => fake()->date("Y-m-d", ),
            "end_date" => fake()->date("Y-m-d", "2025-01-01"),
            "company_id" => 1,
        ];
    }
}
