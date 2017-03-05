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
        $leo->bio = "Some guy";
        $leo->age = 35;
        $leo->dob = "24-03-1992";
        
        $leo->save();
        
        $brad = new Actor();
        $brad->name = "Brad Pitt";
        $brad->bio = "In lots of good movies";
        $brad->age = 38;
        $brad->dob = "19-02-1980";
        
        $brad->save();
        
        $robert = new Actor();
        $robert->name = "Robert Downey Jr";
        $robert->bio = "iron man";
        $robert->age = 40;
        
        $robert->save();
        
        $jake = new Actor();
        $jake->name = "Jake Gylenhaal";
        $jake->bio = "The nightcrawler";
        $jake->age = 30;
        $jake->dob = "24-03-1992";
        
        $jake->save();
        
        $avengers = new Movie();
        $avengers->name = "Avengers";
        $avengers->desc = "Superhero mashup";
        $avengers->rating = 5;
        
        $avengers->save();
        
        $thedeparted = new Movie();
        $thedeparted->name = "The Departed";
        $thedeparted->rating = 5;
        
        $thedeparted->save();
        
        $zodiac = new Movie();
        
        $zodiac->name = "Zodiac";
        $zodiac->desc = "Awesome";
        $zodiac->rating = 5;
        
        $zodiac->save();
        
        $shutter = new Movie();
        $shutter->name = "Shutter Island";
        $shutter->desc = "Mental patients..everywhere";
        $shutter->rating = 4;
        
        $shutter->save();
        
        $inception = new Movie();
        $inception->name = "Inception";
        $inception->desc = "good movie";
        $inception->rating = 4;
        
        $inception->save();
        
        $moneyball = new Movie();
        $moneyball->name = "Moneyball";
        $moneyball->desc = "Sports and stats";
        $moneyball->rating = 5;
        
        $moneyball->save();
        
        $thebigshort = new Movie();
        $thebigshort->name = "The Big Short";
        $thebigshort->desc = "Money money money";
        $thebigshort->rating = 5;
        
        $thebigshort->save();
        
        $thebigshort->actors()->attach($brad->id);
        
        
        $nightcrawler = new Movie();
        $nightcrawler->name = "Nightcrawler";
        $nightcrawler->desc = "Creepy";
        $nightcrawler->rating = 5;
        
        $nightcrawler->save();
        
        $moneyball->actors()->attach($brad->id);
        
        $thedeparted->actors()->attach($leo->id);
        
        $nightcrawler->actors()->attach($jake->id);
        
        $avengers->actors()->attach($robert->id);
        
        $shutter->actors()->attach($leo->id);
        
        $zodiac->actors()->attach($jake->id);
        
        $zodiac->actors()->attach($robert->id);
        
        $inception->actors()->attach($leo->id);
    
        $action = new Genre();
        $action->name = "Action";
        
        $action->save();
        
        $thriller = new Genre();
        $thriller->name = "Thriller";
        
        $thriller->save();
        
        $crime = new Genre();
        $crime->name = "Crime";
        
        $drama = new Genre();
        $drama->name = "Drama";
        
        $drama->save();
        
        $drama->movies()->save($moneyball);
        
        $drama->movies()->save($thebigshort);
        
        $crime->save();
        
        $action->movies()->save($avengers);
        
        $crime->movies()->save($thedeparted);
        
        $crime->movies()->save($zodiac);
        
        $crime->save();
        
        $thriller->movies()->save($shutter);
        
        $thriller->movies()->save($nightcrawler);
        
        $thriller->movies()->save($inception);
        
        $thriller->save();
        
        
        
    }
}
