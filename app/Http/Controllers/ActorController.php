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

class ActorController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    // Get all actors
    public function index(){
        $allActors = Actor::all();
        
        $detailInfo = array(
            
        );
        
        // Create array with all actors
        foreach($allActors as $actor){
            // Each actor's info
            $thisActorArray = array(
                'name' => $actor->name,
                'bio' => $actor->bio,
                'age' => $actor->age,
                'dob' => $actor->dob,
                'movies' => array()
            );
            
            // Each actors movies
            foreach($actor->movies as $movie){
                array_push($thisActorArray['movies'], array(
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating,
                    'genre' => $movie->genre->name
                ));
            }
            
            // Push this actor's info and movies into array
            array_push($detailInfo, $thisActorArray);
        }
        
        // Return list of actors and their specific information
        return Response::json($detailInfo);
    }
    
    // Find actor
    public function find($actorName){
        
        $filteredName = filter_var(trim($actorName),FILTER_SANITIZE_STRING);
        // Find actors with the given name
        $actor = Actor::whereRaw("name = ?", array($filteredName))->firstOrFail();
        
        // Found actor, get information ready
        $detailInfo = array(
            'movies' => array(
                
            ),
            // Actors specific info
            'info' => array(
                'name' => $actor->name,
                'bio' => $actor->bio,
                'age' => $actor->age,
                'dob' => $actor->dob
            )
        );
        
        // Push each of the actor's movie into the array
        foreach($actor->movies as $movie){
            array_push($detailInfo['movies'],  array(
                    'genre' => $movie->genre->name,
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating
                )
            );
        }
        
        // Return detailed information of specific actor
        return Response::json($detailInfo);
        

    }
      // Add an actor to the database
     public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|max:255|string|unique:actors,name',
            'bio' => 'bail|required|max:255|string',
            'age' => 'bail|required|numeric',
            'dob' => 'date_format:"d-m-Y"'
        ]);
        
        // Validation passed, create actor
        
       $newActor = Actor::create($request->all());
        
       // Successfully created actor
       return Response::json(array("created" => true));
        
        
    }
    // Add an actor to a specific movie
    public function addToMovie(Request $request){
        $this->validate($request, [
            'actor' => 'bail|required|max:255|string|exists:actors,name',
            'movie' => 'bail|required|max:255|string|exists:movies,name'
        ]);
        
        // Validation passed
        
        $input = $request->all();
        
        
        // Get the actor model        
        $actor = Actor::whereRaw("name = ?", array($input["actor"]))->firstOrFail();
        
        // Get the movie model
        $movie = Movie::whereRaw("name = ?", array($input["movie"]))->firstOrFail();
        
        // Add actor to movie
        $movie->actors()->attach($actor->id);
        
        // Successfully added actor to movie
        return Response::json(array("created" => true));
    }
}
