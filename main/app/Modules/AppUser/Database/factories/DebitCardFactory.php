<?php

use Faker\Generator as Faker;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\DebitCard;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|	factory('App\Modules\AppUser\Models\DebitCard')->create()
*/

$factory->define(DebitCard::class, function (Faker $faker) {
	// dd($faker->creditCardDetails);
	return [
		'pan' => $faker->creditCardNumber,
		'month' => now()->month,
		'year' => now()->year,
		'cvv' => $faker->randomNumber(3, true),
		'app_user_id' => 2,
		'is_defaul' => 1
	];
});
