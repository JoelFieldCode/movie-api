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
    public function testPOSTRoutes()
    {
        Artisan::call('migrate:refresh');
        
        Artisan::call('db:seed');
        
        $this->json('POST', '/create/movie', ["name" => "The Dark Knight", "desc" => "cool", "rating" => 5,"genre" => "Thriller"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseOk();
             
        $this->json('POST', '/create/actor', ["name" => "Robert Downey Jr", "bio" => "suave dude", "age" => 40, "dob" => "24-03-1992"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseOk();
             
        $this->json('POST', '/create/actor/addToMovie', ["actor" => "Robert Downey Jr", "movie" => "The Dark Knight"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseOk();
             
        $this->json('POST', '/create/genre', ["name" => "Drama"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseOk();
             
    }
    
    public function testGetRoutes()
    {
    
             
        $this->json('GET', '/actor')
             ->seeJsonStructure([
                 "*" => ["name", "bio", "movies", "age", "dob"]
             ])
             ->assertResponseOk();
             
        $this->json('GET', '/actor/Robert Downey Jr')
             ->seeJsonStructure([
                 "info" => ["name", "bio","age", "dob"]
             ])
             ->assertResponseOk();
             
        $this->json('GET', '/movie')
             ->seeJsonStructure([
                 "*" => ["name", "genre", "desc", "rating", "actors"]
             ])
             ->assertResponseOk();
             
        $this->json('GET', '/movie/The Dark Knight')
             ->seeJsonStructure([
                 "name", "genre", "desc", "rating", "actors"
             ])
             ->assertResponseOk();
             
        $this->json('GET', '/genre')
             ->seeJsonStructure([
                 "*" => ["name", "movies"]
             ])
             ->assertResponseOk();
             
        $this->json('GET', '/genre/Drama')
             ->seeJson([
                 "name" => "Drama"
             ])
             ->assertResponseOk();
            
    }
    
}
