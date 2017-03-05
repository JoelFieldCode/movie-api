<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Actor routes */

// Get all the actors
Route::get('actor', [
    'middleware' => 'api',
    'uses' => 'ActorController@index'
]);

// Get detailed information about a specific actor
Route::get('actor/{actorName}', [
    'middleware' => 'api',
    'uses' => 'ActorController@find'
]);

// Create a new actor
Route::post('create/actor', [
    'middleware' => 'api',
    'uses' => 'ActorController@store'
]);

// Add an actor to a movie
Route::post('create/actor/addToMovie', [
    'middleware' => 'api',
    'uses' => 'ActorController@addToMovie'
]);

// Update an actor's profile image, this feature isn't currently working.
Route::post('update/actor/image', [
    'middleware' => 'api',
    'uses' => 'ActorController@updateProfileImage'
]);




/* Movie routes */

// Get all movies
Route::get('movie', [
    'middleware' => 'api',
    'uses' => 'MovieController@index'
]);

// Get detailed information about a specific movie
Route::get('movie/{movieName}', [
    'middleware' => 'api',
    'uses' => 'MovieController@find'
]);

// Create a new movie
Route::post('create/movie', [
    'middleware' => 'api',
    'uses' => 'MovieController@store'
]);






/* Genre Routes */

// Create a new genre
Route::post('create/genre', [
    'middleware' => 'api',
    'uses' => 'GenreController@store'
]);

// Get the detailed information of a specific genre
Route::get('genre/{genreName}', [
    'middleware' => 'api',
    'uses' => 'GenreController@find'
]);

// Retrieve all genres
Route::get('genre', [
    'middleware' => 'api',
    'uses' => 'GenreController@index'
]);

