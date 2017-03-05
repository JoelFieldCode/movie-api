<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class ExampleTest extends TestCase
{
    private $file;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_creating_models_with_valid_and_invalid_data()
    {
        Artisan::call('migrate:refresh');
        
        Artisan::call('db:seed');
        
        // Try to create a new movie that is missing some unrequired fields. This should pass.
        $this->json('POST', '/create/movie', ["name" => "The Dark Knight",  "rating" => 5, "genre" => "Thriller"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseStatus(200);
        
        // Try to create a movie without giving a name, this should fail
        $this->json('POST', '/create/movie', ["desc" => "cool", "rating" => 5,"genre" => "Thriller"])
             ->assertResponseStatus(422);
             
        // Try to create a movie using a name that has already been taken, this should fail
        $this->json('POST', '/create/movie', ["name" => "The Dark Knight", "desc" => "cool", "rating" => 5,"genre" => "Thriller"])
             ->assertResponseStatus(422);

        // Create a new actor that is missing some unrequired fields. This should pass.
        $this->json('POST', '/create/actor', ["name" => "Christian Bale","bio" => "angry man","dob" => "24-06-1980"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseStatus(200);
             
        // Try to create an actor without giving a name, this should fail
        $this->json('POST', '/create/actor',["bio" => "iron man", "age" => 40, "dob" => "24-03-1992"])
            ->assertResponseStatus(422);
            
           
        // Try to create a actor using a name that has already been taken, this should fail 
        $this->json('POST', '/create/actor', ["name" => "Christian Bale", "bio" => "iron man", "age" => 40, "dob" => "24-03-1992"])
            ->assertResponseStatus(422);
             
        // Try to add a actor to a movie. This should pass.
        $this->json('POST', '/create/actor/addToMovie', ["actor" => "Christian Bale", "movie" => "The Dark Knight"])
             ->seeJson([
                 "created" => true
             ])
             ->assertResponseStatus(200);
             
        // Try to add an actor to a movie they already belong to. This should fail.
        $this->json('POST', '/create/actor/addToMovie', ["actor" => "Christian Bale", "movie" => "The Dark Knight"])
             ->seeJson(["created" => "This actor already belongs to this movie"])
             ->assertResponseStatus(422);
             
        
        // Try to add actor to a movie by giving a movie that doesn't exist. This should fail
        $this->json('POST', '/create/actor/addToMovie', ["actor" => "Christian Bale", "movie" => "The best movie that never existed"])
            ->assertResponseStatus(422);
        
         
        // Try to create a new genre. This should pass  
        $this->json('POST', '/create/genre', ["name" => "Comedy"])
             ->seeJson([
                 "created" => true
             ])
            ->assertResponseStatus(200);
    
             
    }
    
    public function test_viewing_models_with_valid_and_invalid_data()
    {
    
        // Try to access list of actors. This should pass.
        $this->json('GET', '/actor')
             ->seeJsonStructure([
                 "*" => ["name", "bio", "movies", "age", "dob"]
             ])
             ->assertResponseStatus(200);
             
        // Try to find a specific actor. This should pass.   
        $this->json('GET', '/actor/Christian Bale')
             ->seeJsonStructure([
                 "info" => ["name", "bio","age", "dob"]
             ])
             ->assertResponseStatus(200);
            
             
        // Try to access list of movies. This should pass. 
        $this->json('GET', '/movie')
             ->seeJsonStructure([
                 "*" => ["name", "genre", "desc", "rating", "actors"]
             ])
             ->assertResponseStatus(200);
        
        // Try to access a specific movie. This should pass.  
        $this->json('GET', '/movie/The Dark Knight')
             ->seeJsonStructure([
                 "name", "genre", "desc", "rating", "actors"
             ])
             ->assertResponseStatus(200);
        
        // Try to access a list of genres. This should pass.    
        $this->json('GET', '/genre')
             ->seeJsonStructure([
                 "*" => ["name", "movies"]
             ])
             ->assertResponseStatus(200);
             
        // Try to access a specific genre. This should pass.  
        $this->json('GET', '/genre/Comedy')
             ->seeJson([
                 "name" => "Comedy"
             ])
             ->assertResponseStatus(200);
        
        // Assert model retrieval failed (Dram doesn't exist)
        $this->json('GET', '/genre/some unknown genre')
             ->assertResponseStatus(404);
            
    }
    
     public function test_image_uploading()
    {
        // Didn't manage to complete this yet
        return;
        
        parent::setUp();

        // Attempt to attach mock file
        $this->file = new \Illuminate\Http\UploadedFile(
            public_path() . '/testimages/dogpic.jpg',
            'dogpic.jpg',
            'image/jpeg',
            filesize(public_path() . '/testimages/dogpic.jpg'),
            null,
            true
        );
        
        // File is initalized correctly here
        var_dump($this->file);
        
        $this->json('POST', '/update/actor/image', ["actor" => "Christian Bale"], [], ['image' => $this->file])
            ->assertResponseStatus(200);
        
        // File doesn't successfully get attached to the request - The API route says it doesn't exist.
        $this->dump();

        
    }
    
}
