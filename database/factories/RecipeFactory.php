<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Recipe;
use App\Models\User;
use Faker\Generator;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Support\Str;

$factory->define(Recipe::class, static function (Generator $faker) {
    $restFactory = \Faker\Factory::create();
    $restFactory->addProvider(new Restaurant($restFactory));
    
    return [
        'user_id' => User::all()->random()->id,
        'title' => $restFactory->foodName(),
        'description' => $faker->realText(200)
    ];
});
