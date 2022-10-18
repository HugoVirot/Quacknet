<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // création d'un admin
        User::create(
            [
                'pseudo' => 'admin',
                'image' => 'admin.jpg',
                'email' => 'admin@admin.fr',
                'email_verified_at' => now(),
                'password' => Hash::make("Azerty88@"),
                'role_id' => 2,
                'remember_token' => Str::random(10),
            ]
        );

        // création de 20 users aléatoires avec la factory
        \App\Models\User::factory(20)->create();
    }
}
