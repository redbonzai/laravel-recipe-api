<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'API\AuthController@register')->name('register.api');
Route::post('/login', 'API\AuthController@login')->name('login.api');
Route::post('/logout', 'API\AuthController@logout')->name('logout.api');

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], static function () {
    Route::get('/{user_id}', 'API\UserController@index');
});

Route::group(['prefix' => 'recipes', 'middleware' => 'auth:api'], static function () {
    Route::get('/', 'API\RecipeController@index');
    Route::get('/{recipe_id}', 'API\RecipeController@show');
    Route::post('/', 'API\RecipeController@store');
    Route::put('/{recipe_id}', 'API\RecipeController@update');
    Route::patch('/{recipe_id}', 'API\RecipeController@update');
    Route::delete('/{recipe_id}', 'API\RecipeController@destroy');
});

Route::group(['prefix' => 'ingredients', 'middleware' => 'auth:api'], static function () {
    Route::get('/', 'API\IngredientController@index');
    Route::get('/{ingredient_id}', 'API\IngredientController@show');
    Route::get('/recipe/{recipe_id}', 'API\IngredientController@getIngredientsByRecipeId');
    Route::post('/', 'API\IngredientController@store');
    Route::put('/{ingredient_id}', 'API\IngredientController@update');
    Route::patch('/{ingredient_id}', 'API\IngredientController@update');
    Route::delete('/{ingredient_id}', 'API\IngredientController@destroy');
});

Route::group(['prefix' => 'steps', 'middleware' => 'auth:api'], static function () {
    Route::get('/', 'API\StepController@index');
    Route::get('/{step_id}', 'API\StepController@show');
    Route::get('/recipe/{recipe_id}', 'API\StepController@getStepsByRecipeId');
    Route::post('/', 'API\StepController@store');
    Route::put('/{step_id}', 'API\StepController@update');
    Route::patch('/{step_id}', 'API\StepController@update');
    Route::delete('/{step_id}', 'API\StepController@destroy');
});


