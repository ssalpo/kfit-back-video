<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'source_type' => 1, // Kinescope
            'source_id' => '5c64ee06-3104-4cd4-a364-709d9f291eaf',
            'is_public' => $this->faker->boolean(),
        ];
    }
}
