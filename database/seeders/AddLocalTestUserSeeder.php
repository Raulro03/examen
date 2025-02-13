<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddLocalTestUserSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment() === 'local') {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@mail.es',
                'password' => bcrypt('12345678'),
                'role' => 'admin'
            ]);

            User::create([
                'name' => 'Test User 2',
                'email' => 'client@mail.es',
                'password' => bcrypt('12345678'),
                'role' => 'client'
            ]);

            $courses = Course::all();
            $user->purchasedCourses()->attach($courses);
        }
    }
}
