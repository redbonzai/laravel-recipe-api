<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Ingredient;
    use App\Models\Recipe;
    use Faker\Generator as Faker;
use FakerRestaurant\Provider\en_US\Restaurant;
    
    $factory->define(Ingredient::class, static function (Faker $faker) {
        $restFactory = \Faker\Factory::create();
        $restFactory->addProvider(new Restaurant($restFactory));
    
        return [
            'recipe_id' => Recipe::all()->random()->id,
            'name' => $restFactory->foodName(),
            'quantity' => $faker->numberBetween(1, 200),
        ];
});
