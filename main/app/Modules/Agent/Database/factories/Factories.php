<?php

use App\Modules\Agent\Models\Agent;
use Faker\Generator as Faker;

$factory->define(Agent::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => 'collector@amju.com',
    'password' => 'pass',
    'phone' => '07059312514',
    'bvn' => '2567890-98765432',
    'avatar' => $faker->imageUrl(),
    'gender' => $faker->randomElement(['male', 'female']),
    'address' => $faker->address,
    'dob' => now()->subYears(45),
    'verified_at' => now()->subDays(45),
  ];
});
