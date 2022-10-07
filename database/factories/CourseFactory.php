<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'cover' => '',
            'duration' => sprintf('%s:%s', rand(1, 12), rand(0, 59)),
            'level' => rand(1, 3),
            'muscles' => '',
            'type' => '',
            'description' => $this->faker->paragraph(200),
            'is_public' => $this->faker->boolean(),
        ];
    }
}
