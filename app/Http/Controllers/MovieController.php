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

class MovieController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function index(){
        $allMovies = Movie::all();
        
        $detailInfo = array();
        
        foreach($allMovies as $movie){
            $thisMovieArray = array(
                'name' => $movie->name,
                'genre' => $movie->genre->name,
                'desc' => $movie->desc,
                'rating' => $movie->rating,
                'actors' => array()
            );
            foreach($movie->actors as $actor){
                array_push($thisMovieArray['actors'], array(
                    'name' => $actor->name,
                    'age' => $actor->age,
                    'bio' => $actor->bio
                ));
            }
            
            array_push($detailInfo, $thisMovieArray);
        }
        
        return Response::json($detailInfo);
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|max:255|string|unique:movies,name',
            'desc' => 'bail|required|max:255|string',
            'rating' => 'bail|required|numeric',
            'genre' => 'bail|required|max:255|string',
        ]);
        
        $genre = Genre::whereRaw("name = ?", array($request->genre))->first();
        if(count($genre) < 1){
            $genre = Genre::create($request);
        }
        
        $newMovie = Movie::create($request);
        
        $genre->movies()->save($newMovie);
        
        return Response::json($newMovie);
        
        
    }
    
    public function find($movieName){
        
        
        
        $movie = Movie::whereRaw("name = ?", array($movieName))->firstOrFail();
    
        
        $detailInfo = array(
            'name' => $movie->name,
            'desc' => $movie->desc,
            'rating' => $movie->rating,
            'genre' => $movie->genre->name,
            'actors' => array(
            )
        );
        
        foreach($movie->actors as $actor){
            array_push($detailInfo['actors'], array(
                 "bio" => $actor->bio,
                 'name' => $actor->name,
                 'age' => $actor->age
            ));
        }
        
        return Response::json($detailInfo);
        
    

    }
}
