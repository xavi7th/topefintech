<?php

use Faker\Generator as Faker;
use App\Modules\Admin\Models\Admin;

$factory->define(Admin::class, function (Faker $faker) {
  return [
    'full_name' => 'Grant Aghedo',
    'email' => 'grant@amju.com',
    'password' => 'pass',
    'phone' => '08034444444444',
    'bvn' => '2567890-98765432',
    'user_passport' => '/storage/',
    'gender' => 'male',
    'address' => '211 56789ygfhbffgh876545c 97564y',
    'dob' => now()->subYears(45),
    'verified_at' => now()->subDays(45),
  ];
});
