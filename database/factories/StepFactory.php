<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Recipe;
use App\Models\Step;
use Faker\Generator as Faker;
use FakerRestaurant\Provider\en_US\Restaurant;

$factory->define(Step::class, static function (Faker $faker) {
    $restFactory = \Faker\Factory::create();
    $restFactory->addProvider(new Restaurant($restFactory));
   
    return [
        'recipe_id' => Recipe::all()->random()->id,
        'step_order' => $faker->numberBetween(1, 20),
        'description' => $faker->text(200),
    ];
});
