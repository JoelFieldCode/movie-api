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
use app\Actor;

class GenreController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function test($genreName){
        
        
        
        $genre = Genre::whereRaw("name = ?", array($genreName))->firstOrFail();
        
        $movies = $genre->movies;
        
        $actorsArray = array();
        
        foreach($movies as $movie){
            foreach($movie->actors as $actor){
                $actorsArray[$actor->name] = array(
                    "bio" => $actor->bio    
                );
            }
        }
        
        return Response::json($actorsArray);
        
        
        return Response::json($movies);
        
        return Response::json($genre);

    }
}
