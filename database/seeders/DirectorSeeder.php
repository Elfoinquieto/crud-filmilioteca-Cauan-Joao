<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DirectorSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 30; $i++) {
            Director::create([
                'user_id' => $user->id,
                'name' => $faker->name(),
            ]);
        }
    }
}