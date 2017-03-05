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
use Illuminate\Http\UploadedFile;

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
        
        
        // Find actors with the given name
        $actor = Actor::whereRaw("name = ?", array($actorName))->firstOrFail();
        
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
            'bio' => 'bail|max:255|string',
            'age' => 'bail|numeric',
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
        
        // Determine if this movie already has this actor attached to it
        if($movie->hasActor($actor) === true){
            return Response::json([
                "created" => "This actor already belongs to this movie"
            ],422);
        }
        
        // Add actor to movie
        $movie->actors()->attach($actor->id);
        
        // Successfully added actor to movie
        return Response::json(array("created" => true));
    }
    
    // This feature doesn't work yet. Explanations in the comments here and in the test case.
    public function updateProfileImage(Request $request){
        $this->validate($request, [
            // 'image' => 'bail|required|image',
            'actor' => 'bail|required|max:255|string|exists:actors,name',
        ]);
        
        // See if we properly received a file from the request. This part isn't working properly as the file is coming through as NULL.
        var_dump($request->file('image'));
        
        return "test";
        
        // Set destination path
        $destinationPath = public_path().'/images';
        
        // Grab file
        $file = $request->file('image');
        
        // Grab file name
        $name = $file->getClientOriginalName();
        
        // Move file to images folder
        $file->move($destinationPath, $name);
        
        $input = $request->all();
        
        // Get the actor model        
        $actor = Actor::whereRaw("name = ?", array($input["actor"]))->firstOrFail();
        
        // Update actor's image filename
        $actor->image = $name;
        
        $actor->save();
        
    }
}
