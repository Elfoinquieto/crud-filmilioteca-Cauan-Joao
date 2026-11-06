<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $faker = Faker::create('pt_BR');
        $authorIds = Author::where('user_id', $user->id)->pluck('id')->toArray();
        $genres = defined('App\Models\Book::GENRES') 
            ? \App\Models\Book::GENRES 
            : ['Fantasia', 'Ficção Científica', 'Mistério', 'Romance', 'Terror', 'Aventura', 'Drama'];

        for ($i = 0; $i < 30; $i++) {
            Book::create([
                'user_id' => $user->id,
                'title' => ucwords($faker->words($faker->numberBetween(2, 5), true)),
                'isbn' => $faker->isbn13(),
                'genre' => $faker->randomElement($genres),
                'description' => $faker->paragraph(3),
                'author_id' => !empty($authorIds) ? $faker->randomElement($authorIds) : null,
            ]);
        }
    }
}