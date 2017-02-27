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

Route::get('/', function () {
    return view('welcome');
});

Route::get('genre/{genreName}', [
    'middleware' => 'web',
    'uses' => 'GenreController@test'
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
