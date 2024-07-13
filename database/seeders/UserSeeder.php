<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = ['admin'];
        $config= Config::first();
        foreach ($users as $user) {
            User::create([
                'name' => ucwords($user),
                'email' => $user.'@gmail.com',
                'STDID' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole($user);
        }

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '09' . random_int(100000000, 999999999),
                'STDID' => $config->generate_student_id(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole('instructor');

            $config->update_student_id_index();
        }

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '09' . random_int(100000000, 999999999),
                'STDID' => $config->generate_student_id(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole('student');

            $config->update_student_id_index();
        }
    }
}
