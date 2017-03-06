<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Determine if this movie already has this actor attached to it
    public function hasActor($actor){
        foreach($this->actors as $actorInThisMovie){
            if($actor->name === $actorInThisMovie->name){
                return true;
            }
        }
        return false;
    }
    
    public function genre(){
        return $this->belongsTo('App\Genre');
    }
    
    public function actors(){
        return $this->belongsToMany('App\Actor');
    }
    
    protected $fillable = [
        'name', 'desc', 'rating'  
    ];
}
