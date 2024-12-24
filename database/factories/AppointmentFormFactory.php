<?php

namespace Database\Factories;

use App\Models\AppointmentForm;
use App\Models\Position;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFormFactory extends Factory
{
    protected $model = AppointmentForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_id' => Position::factory(), // Create a new Position or associate with an existing one
            'slot_id' => Slot::factory(),         // Create a new Slot or associate with an existing one
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'contact' => $this->faker->phoneNumber(),
            'cover_letter' => $this->faker->paragraph(3),
            'resume' => 'resumes/'.$this->faker->uuid().'.pdf', // Example resume path
            'date' => $this->faker->date('Y-m-d'),
            'status' => $this->faker->randomElement(['scheduled', 'done', 'canceled']),
            'mode' => $this->faker->randomElement(['in-person', 'virtual']),
            'image' => 'images/' . $this->faker->uuid() . '.jpg', // Example image path
        ];
    }
}
