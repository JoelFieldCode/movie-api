<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetRoutes()
    {
    
             
        $this->json('GET', '/actor')
             ->seeJsonStructure([
                 "*" => ["name", "bio", "movies", "age"]
             ]);   
        $this->json('GET', '/actor/Leonardo%20Dicaprio')
             ->seeJsonStructure([
                 "info" => ["name", "bio","age"]
             ]);  
             
        $this->json('GET', '/movie')
             ->seeJsonStructure([
                 "*" => ["name", "genre", "desc", "rating", "actors"]
             ]); 
             
        $this->json('GET', '/movie/Inception')
             ->seeJsonStructure([
                 "name", "genre", "desc", "rating", "actors"
             ]);
             
        $this->json('GET', '/genre')
             ->seeJsonStructure([
                 "*" => ["name", "movies"]
             ]);
             
        $this->json('GET', '/genre/Thriller')
             ->seeJson([
                 "name" => "Thriller"
             ]); 
            
    }
    
    public function testPOSTRoutes()
    {
        $this->json('POST', '/create/movie', ["name" => "The Dark Knight", "desc" => "cool", "rating" => 5,"genre" => "Thriller"])
             ->seeJson([
                 "created" => true
             ]);
             
        $this->json('POST', '/create/actor', ["name" => "Robert Downey Jr", "bio" => "suave dude", "age" => 40])
             ->seeJson([
                 "created" => true
             ]);
             
        $this->json('POST', '/create/addActorToMovie', ["actorName" => "Robert Downey Jr", "movie" => "Zodiac"])
             ->seeJson([
                 "created" => true
             ]);
             

        
    }
    
}
