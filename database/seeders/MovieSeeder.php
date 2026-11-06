<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $faker = Faker::create('pt_BR');
        $directorIds = Director::where('user_id', $user->id)->pluck('id')->toArray();
        $actorIds = Actor::where('user_id', $user->id)->pluck('id')->toArray();
        $genres = defined('App\Models\Movie::GENRES') 
            ? \App\Models\Movie::GENRES 
            : ['Ação', 'Comédia', 'Drama', 'Ficção Científica', 'Terror', 'Romance', 'Documentário'];

        for ($i = 0; $i < 30; $i++) {
            $movie = Movie::create([
                'user_id' => $user->id,
                'title' => ucwords($faker->words($faker->numberBetween(1, 4), true)),
                'genre' => $faker->randomElement($genres),
                'description' => $faker->paragraph(3),
                'director_id' => !empty($directorIds) ? $faker->randomElement($directorIds) : null,
            ]);

            // Associa entre 1 e 4 atores aleatórios a cada filme na tabela pivot
            if (!empty($actorIds)) {
                $randomActors = $faker->randomElements($actorIds, $faker->numberBetween(1, min(4, count($actorIds))));
                $movie->actors()->sync($randomActors);
            }
        }
    }
}