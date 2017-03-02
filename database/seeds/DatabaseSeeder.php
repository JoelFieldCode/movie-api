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
        
        $jake = new Actor();
        $jake->name = "Jake Gylenhaal";
        $jake->bio = "Some dude";
        $jake->age = 30;
        
        $jake->save();
        
        $zodiac = new Movie();
        
        $zodiac->name = "Zodiac";
        $zodiac->desc = "Awesome";
        $zodiac->rating = 3;
        
        $zodiac->save();
        
        $inception = new Movie();
        $inception->name = "Inception";
        $inception->desc = "Cool Movie";
        $inception->rating = 4;
        
        $inception->save();
        
        $nightcrawler = new Movie();
        $nightcrawler->name = "Nightcrawler";
        $nightcrawler->desc = "Creepy";
        $nightcrawler->rating = 5;
        
        $nightcrawler->save();
        
        $nightcrawler->actors()->attach($jake->id);
        
        $zodiac->actors()->attach($jake->id);
        
        $inception->actors()->attach($leo->id);
    
        
        $thriller = new Genre();
        $thriller->name = "Thriller";
        
        $thriller->save();
        
        $crime = new Genre();
        $crime->name = "Crime";
        
        $crime->save();
        
        $crime->movies()->save($zodiac);
        
        $crime->save();
        
        $thriller->movies()->save($nightcrawler);
        
        $thriller->movies()->save($inception);
        
        $thriller->save();
        
        
        
    }
}
