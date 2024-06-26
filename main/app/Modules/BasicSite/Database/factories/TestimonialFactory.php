<?php

use App\User;
use Faker\Generator as Faker;
use App\Modules\BasicSite\Models\Testimonial;


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

$factory->define(Testimonial::class, function (Faker $faker) {

	return [
		'name' => $faker->name,
		'city' => $faker->city,
		'country' => $faker->randomElement(['USA', 'UK', 'Brazil', 'Portugal', 'Argentina', 'Kenya', $faker->country]),
		'img' => '/storage/testimonial_images/',
		'testimonial' => $faker->text(),
	];
});
