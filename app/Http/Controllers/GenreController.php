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

class GenreController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    // Retrieve all genres
    public function index(){
        $allGenres = Genre::all();
        
        $detailInfo = array(
        );
        
        // Add each genre's info into array
        foreach($allGenres as $genre){
            $thisGenreArray = array(
                'name' => $genre->name,
                'movies' => array()
            );
            
            // Add each genre's movies into array
            foreach($genre->movies as $movie){
                $thisMovieArray = array(
                    'desc' => $movie->desc,
                    'name' => $movie->name,
                    'rating' => $movie->rating
                );
                
                // Add this movie into this genre's array of movies
                array_push($thisGenreArray['movies'], $thisMovieArray);
            }
            // Add this genre to the array of genres
            array_push($detailInfo, $thisGenreArray);
        }
        
        // Return list of genres and their specific information
        return Response::json($detailInfo);
    }
    
    // Add genre
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|string|unique:genres,name',
        ]);
        
        // Validation passed
        
        // Create genre
        $newGenre = Genre::create($request->all());
        
        //Successfully created    
        return Response::json(array("created" => true));
    }
    
    // Find genre
    public function find($genreName){
        
        // Find genre with the given name
        $genre = Genre::whereRaw("name = ?", array($genreName))->firstOrFail();
        
        $actorsArray = array();
        
        // Start filling up array with info about this genre
        $detailInfo = array(
            'movies' => array(
                
            ),
            'actors' => array(
                
            ),
            'name' => $genre->name
        );
        
        // Add each movie from this genre to array
        foreach($genre->movies as $movie){
            array_push($detailInfo['movies'], array(
                    'genre' => $movie->genre->name,
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating
            ));
            
            /* Add all actors across multiple movies into array. 
            *  This should be done differently as this loop will repeat the same actor x times if they appeared in multiple movies of the same genre. 
            *  Though they will only appear once in the JSON response
            */
            
            foreach($movie->actors as $actor){
                $actorsArray[$actor->name] = array(
                    "bio" => $actor->bio    
                );
            }
        }
        
        // Add array of actors to detail information array
        $detailInfo['actors'] = $actorsArray;
        
        // Return this genre's information
        return Response::json($detailInfo);
        
    }
}
