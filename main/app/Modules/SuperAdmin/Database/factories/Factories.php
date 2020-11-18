<?php

use App\Modules\SuperAdmin\Models\SuperAdmin;
use Faker\Generator as Faker;

$factory->define(SuperAdmin::class, function (Faker $faker) {
  return [
    'full_name' => 'Grant Aghedo',
    'email' => 'grant@amju',
    'password' => 'pass',
    'phone' => '080344444444',
    'bvn' => '256789098765432',
    'user_passport' => '/storage/',
    'gender' => 'male',
    'address' => '211 56789ygfhbffgh876545c 97564y',
    'dob' => now()->subYears(45),
    'verified_at' => now()->subDays(45),
  ];
});
