<?php

namespace Database\Seeders;

use App\Models\Company;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        foreach (range(1,21) as $i){
            Company::query()->create(
                [
                    'name' => $faker->unique()->words(rand(2,4), true),
                    'email' => $faker->unique()->email(),
                    'phone' => $faker->unique()->phoneNumber(),
                ],
            );
        }
    }
}
