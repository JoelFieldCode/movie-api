<?php

use Illuminate\Database\Seeder;

use App\Actor;
use App\Movie;
use App\Genre;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        $leo = new Actor();
        $leo->name = "Leonardo Dicaprio";
        $leo->bio = "Cool dude";
        $leo->age = 35;
        
        $leo->save();
        
        
        $inception = new Movie();
        $inception->name = "Inception";
        $inception->desc = "Cool Movie";
        $inception->rating = 5;
        
        $inception->save();
        
        $inception->actors()->attach($leo->id);
    
        
        $thriller = new Genre();
        $thriller->name = "Thriller";
        
        $thriller->save();
        
        $thriller->movies()->save($inception);
        
        $thriller->save();
        
        
        
    }
}
