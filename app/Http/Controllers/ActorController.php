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

class ActorController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function index(){
        $allActors = Actor::all();
        
        $detailInfo = array(
            
        );
        foreach($allActors as $actor){
            $thisActorArray = array(
                'name' => $actor->name,
                'bio' => $actor->bio,
                'age' => $actor->age,
                'movies' => array()
            );
            foreach($actor->movies as $movie){
                array_push($thisActorArray['movies'], array(
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating,
                    'genre' => $movie->genre->name
                ));
            }
            array_push($detailInfo, $thisActorArray);
        }
        
        return Response::json($detailInfo);
    }
    
    public function find($actorName){
        
        
        $actor = Actor::whereRaw("name = ?", array($actorName))->firstOrFail();
        
        
        $detailInfo = array(
            'movies' => array(
                
            ),
            'info' => array(
                'name' => $actor->name,
                'bio' => $actor->bio,
                'age' => $actor->age
            )
        );
        
        foreach($actor->movies as $movie){
            array_push($detailInfo['movies'],  array(
                    'genre' => $movie->genre,
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating
                )
            );
        }
        
        return Response::json($detailInfo);
        

    }
    
     public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|max:255|string|unique:actors,name',
            'bio' => 'bail|required|max:255|string',
            'age' => 'bail|required|numeric',
        ]);
        
       $newActor = Actor::create($request);
        
       return Response::json($newActor);
        
        
    }
    
    public function addMovie(Request $request){
        
    }
}
