<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            User::factory(5)->create();
            $users = User::all();
        }

        Testimonial::factory(5)->create([
            'user_id' => fn() => $users->random()->id,
        ]);
    }
}
