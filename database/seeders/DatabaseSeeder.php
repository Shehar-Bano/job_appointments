<?php

namespace Database\Seeders;

use App\Models\AppointmentForm;
use App\Models\Position;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        if(Slot::count() != 0){
            Slot::factory()->count(20)->create();
        }
        if(Position::count() != 0){
            Position::factory()->count(20)->create();
        }
       if(AppointmentForm::count() !== 0){
            AppointmentForm::factory()->count(20)->create();
        }
    }
}
