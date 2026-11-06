<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $faker = Faker::create('pt_BR');
        $genres = ['Fantasia', 'Ficção Científica', 'Mistério', 'Romance', 'Terror', 'Aventura', 'História'];

        for ($i = 0; $i < 30; $i++) {
            Author::create([
                'user_id' => $user->id,
                'name' => $faker->name(),
                'age' => $faker->numberBetween(25, 90),
                'literary_genre' => $faker->randomElement($genres),
                'nationality' => $faker->country(),
            ]);
        }
    }
}