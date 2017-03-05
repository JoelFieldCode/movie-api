<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\DB;
use Response;
use App\Genre;
use App\Movie;
use App\Actor;
use Illuminate\Http\Request;

class MovieController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    // Get all Movies
    public function index(){
        
        $allMovies = Movie::all();
        
        if(count($allMovies->toArray()) < 1){
            abort(404);
        }
        
        $detailInfo = array();
        
        // Add each movie to array
        foreach($allMovies as $movie){
            $thisMovieArray = array(
                'name' => $movie->name,
                'genre' => $movie->genre->name,
                'desc' => $movie->desc,
                'rating' => $movie->rating,
                'actors' => array()
            );
            // Add each movie's actors to array
            foreach($movie->actors as $actor){
                array_push($thisMovieArray['actors'], array(
                    'name' => $actor->name,
                    'age' => $actor->age,
                    'bio' => $actor->bio
                ));
            }
            // Push the movie to the array of movies
            array_push($detailInfo, $thisMovieArray);
        }
        
        // Return list of movies and their information
        return Response::json($detailInfo);
    }
    
    // Add a movie
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|max:255|string|unique:movies,name',
            'desc' => 'bail|max:255|string',
            'rating' => 'bail|numeric',
            'genre' => 'bail|required|max:255|string|exists:genres,name',
        ]);
        // Validation passed
        
        $input = $request->all();
        
        // Find genre so we can attach it to this movie
        $genre = Genre::whereRaw("name = ?", array($input["genre"]))->firstOrFail();
        
        // Create new movie
        $newMovie = Movie::create($input);
        
        // Add movie to genre
        $genre->movies()->save($newMovie);
        
        // Created successfully
        return Response::json(array("created" => true));
        
        
    }
    
    // Find a movie
    public function find($movieName){
        
        // Find movie based on the input, or fail
        $movie = Movie::whereRaw("name = ?", array($movieName))->firstOrFail();
    
        // Found movie, fill up array with details about this movie
        $detailInfo = array(
            'name' => $movie->name,
            'desc' => $movie->desc,
            'rating' => $movie->rating,
            'genre' => $movie->genre->name,
            'actors' => array(
            )
        );
        
        // Create array showing the actors in this movie
        foreach($movie->actors as $actor){
            array_push($detailInfo['actors'], array(
                 "bio" => $actor->bio,
                 'name' => $actor->name,
                 'age' => $actor->age
            ));
        }
        
        // Return this movie's detailed information
        return Response::json($detailInfo);
    }
}
