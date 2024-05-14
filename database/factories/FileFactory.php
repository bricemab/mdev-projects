<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "unique_name" => Str::random(12),
            'path' => "files/",
            'extension' => fake()->fileExtension(),
            'size' => fake()->numberBetween(1000, 999999999),
            "company_id" => 1
        ];
    }
}
