<?php

use Faker\Generator as Faker;
use App\Modules\AppUser\Models\AppUser;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(AppUser::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->unique()->safeEmail,
    'email_verified_at' => now(),
    'verified_at' => now(),
    'password' => 'pass',
    'country' => $faker->country,
    'phone' => $faker->phoneNumber,
    'id_card' => '/storage/id_cards/',
    'remember_token' => Str::random(10),
  ];
});
