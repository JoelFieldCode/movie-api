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
use App\Genre;
use App\Movie;
use App\Actor;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin', '*');

Route::get('/', function () {
    return view('welcome');
});

Route::get('actor', [
    'middleware' => 'api',
    'uses' => 'ActorController@index'
]);

Route::get('actor/{actorName}', [
    'middleware' => 'api',
    'uses' => 'ActorController@find'
]);

Route::get('movie/{movieName}', [
    'middleware' => 'api',
    'uses' => 'MovieController@find'
]);
Route::get('movie', [
    'middleware' => 'api',
    'uses' => 'MovieController@index'
]);

Route::post('create/movie', [
    'middleware' => 'api',
    'uses' => 'MovieController@store'
]);

Route::post('create/actor', [
    'middleware' => 'api',
    'uses' => 'ActorController@store'
]);

Route::post('create/addActorToMovie', [
    'middleware' => 'api',
    'uses' => 'ActorController@addActorToMovie'
]);


Route::get('genre/{genreName}', [
    'middleware' => 'api',
    'uses' => 'GenreController@find'
]);

Route::get('genre', [
    'middleware' => 'api',
    'uses' => 'GenreController@index'
]);

Route::get('test', function () {
    // return GenreController::test();
    $genre = Genre::find(1);
    $movie = Movie::find(1);
    $actor = Actor::find(1);
    return Response::json($actor->movies);
    return Response::json($movie->actors);
    return Response::json($genre->movies);
});
