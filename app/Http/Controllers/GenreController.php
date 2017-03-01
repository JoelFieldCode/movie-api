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

class GenreController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function index(){
        $allGenres = Genre::all();
        
        $detailInfo = array(
        );
        
        foreach($allGenres as $genre){
            $thisGenreArray = array(
                'name' => $genre->name,
                'movies' => array()
            );
            foreach($genre->movies as $movie){
                $thisMovieArray = array(
                    'desc' => $movie->desc,
                    'name' => $movie->name,
                    'rating' => $movie->rating
                );
                array_push($thisGenreArray['movies'], $thisMovieArray);
            }
            array_push($detailInfo, $thisGenreArray);
        }
        
        return Response::json($detailInfo);
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|unique:genres,name',
        ]);
    }
    
    public function find($genreName){
        
        
        
        $genre = Genre::whereRaw("name = ?", array($genreName))->firstOrFail();
        
        $actorsArray = array();
        
        $detailInfo = array(
            'movies' => array(
                
            ),
            'actors' => array(
                
            )
        );
        
        foreach($genre->movies as $movie){
            array_push($detailInfo['movies'], array(
                    'genre' => $movie->genre,
                    'name' => $movie->name,
                    'desc' => $movie->desc,
                    'rating' => $movie->rating
            ));
            foreach($movie->actors as $actor){
                $actorsArray[$actor->name] = array(
                    "bio" => $actor->bio    
                );
            }
        }
        
        $detailInfo['actors'] = $actorsArray;
        
        return Response::json($detailInfo);
        
        

    }
}
