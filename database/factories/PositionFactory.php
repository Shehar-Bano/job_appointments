<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'job_type' => $this->faker->randomElement(['full_time', 'part_time']),
            'qualification' => $this->faker->randomElement(['Bachelor\'s Degree', 'Master\'s Degree', 'High School Diploma']),
            'experience' => $this->faker->numberBetween(1, 10) . ' years',
            'skills' => implode(', ', $this->faker->words(3)), // Optional skill list
            'status' => $this->faker->randomElement(['open', 'close']),
            'description' => $this->faker->paragraphs(3, true), // Detailed job description
            'post_date' => $this->faker->date(), // Random post date
        ];
    }
}
