If you don't want to set up this API locally then you can just use the Front-End App & the Apiary document to see how all the routes respond. 
I will keep this API up at https://movie-api-joelfieldcode.c9users.io/movieAPI/public/


Instructions (if you want to run this API locally):

Run composer install

Next: Create a .env file, copy in the details from env.example

Next: Generate your APP_KEY with this command:

php artisan key:generate

Next: Create the Database by running this command:

touch database/database.sqlite

Run tests using the following command to verify everything was set up correctly:

./vendor/bin/phpunit

The test script will run the migrations and seeding for you.



API Documentation:

http://docs.movieapi58.apiary.io/







Raw documentation (The Apiary link is good for showing all the correct request bodies & 200 status code responses. However, it isn't showing the extra invalid request/responses I wrote
in the document):



FORMAT: 1A
HOST: https://movie-api-joelfieldcode.c9users.io/movieAPI/public/

# Movie API

Movie API is a simple service allowing users to create/read relationships between Actors, Movies & Genres.


## Actors Collection [/actor]

### List All Actors and their movies [GET]

+ Request (application/json)

+ Response 200 (application/json)

        [
            {
                "name": "Leonardo Dicaprio",
                "bio": "Cool Dude",
                "age" : 40,
                "movies": [
                    {
                        "name" : "Inception
                        "desc": "good",
                        "rating": 5,
                        "genre" : "Thriller"
                    },
                    {
                        "name" : "Shutter Island"
                        "desc": "great",
                        "rating": 4,
                        "genre" : "Thriller
                    }
                ]
            },
        ]
        
## Add Actor [/create/actor]

### Add an actor to the database [POST]

-- Required fields: "name"

+ Request (application/json)

    + Body
    
        {
            "name" : "Chris Hemsworth", 
            "bio" : "Thor", 
            "age" : 30, 
            "dob" : "24-03-1992"
        }
            
+ Response 200 (application/json)

    + Body
            {
                "created" : true
            }

// Try to create an actor without giving a name (required field)          
+ Request (application/json)

    + Body
            {
                "bio" : "iron man", 
                "age" : 40, 
                "dob" : "24-03-1992"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "name" : {
                    0 : "The name field is required."
                }
            }
            
            
// Try to create an actor that already exists            
+ Request (application/json)
    
    + Body
            {
                "name" : "Robert Downey Jr", 
                "bio" : "iron man", 
                "age" : 40, 
                "dob" : "24-03-1992"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "actor" : {
                    0 : "The name has already been taken"
                }
            }
            
## Add Actor to a Movie [/create/actor/addToMovie]

### Add an actor to a Movie [POST]

-- Required fields: "actor", "movie"

+ Request (application/json)
    
    + Body
            {
                "actor" : "Leonardo Dicaprio", 
                "movie" : "The Dark Knight"
            }
            
+ Response 200 (application/json)

    + Body
            {
                "created" : true
            }

// Try to add actor to a movie by giving a movie that doesn't exist. This should fail      
+ Request: 

    + Body
            {
                "actor" : "Robert Downey Jr", 
                "movie" : "I don't exist"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "movie" : {
                    0 : "The selected movie is invalid."
                }
            }
        
## Actor Detail [/actor/{actor_name}]

### See detail of an Actor [GET]

+ Parameters
    + actor_name (string) - Name of the actor

+ Response 200 (application/json)

    + Body
            {
               "info" : {
                    "name": "Robert Downey Jr",
                    "bio": "iron man",
                    "age":"40.0",
                    "dob": "24-03-1992"
                },
                "movies": [
                    {
                        "genre": "Thriller",
                        "name": "The Dark Knight",
                        "desc": "cool",
                        "rating": "5.0"
                    },
                ]
            }

// Request an Actor that doesn't exist (e.g actor_name=unknown guy)
           
+ Response 404 (Resource not found - application/json)







## Movies Collection [/movie]

### List all Movies and their actors [GET]

+ Request (application/json)

+ Response 200 (application/json)

        [
            {
                "name": "Zodiac",
                "genre": "Crime",
                "desc": "Awesome",
                "rating": "3.0",
                "actors": [
                    {
                        "name":"Jake Gylenhaal",
                        "age":"30.0",
                        "bio": "The nightcrawler"
                    },
                    {
                        "name":"Robert Downey Jr",
                        "age":"30.0",
                        "bio": "test"
                    }
                ]
            },
            {
                "name": "Inception",
                "genre": "Thriller",
                "desc": "Awesome",
                "rating": "3.0",
                "actors": [
                    {
                        "name":"test2",
                        "age":"30.0",
                        "bio": "The nightcrawler"
                    },
                    {
                        "name":"test3",
                        "age":"30.0",
                        "bio": "test"
                    }
                ]
            },
        ]
        
## Add Movie [/create/movie]

### Add a Movie to the database [POST]

-- Required fields: "name, "genre"

+ Request (application/json)

    + Body
    
            {
               "name" : "The Nice Guys",
               "desc" : "cool",
               "rating" : 5,
               "genre" : "Thriller"
            }
            
+ Response 200 (application/json)

    + Body
            {
                "created" : true
            }
      
// Try to create a movie without giving a name(required field)  
+ Request (application/json) 

    +  Body
            {
                "desc" : "cool",
                "rating" : 5,
                "genre" : "Thriller"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "name" : {
                    0 : "The name field is required."
                }
            }
            
// Try to create a movie without giving a genre(required field)  
+ Request (application/json) 

    +  Body
            {
                "Name" : "Avengers"
                "desc" : "cool",
                "rating" : 5,
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "genre" : {
                    0 : "The genre field is required."
                }
            }
            
            
// Try to create a movie that already exists            
+ Request (application/json)

    +Body
            {
               "name" : "The Dark Knight",
               "desc" : "cool",
               "rating" : 5,
               "genre" : "Thriller"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "movie" : {
                    0 : "The name has already been taken"
                ]
            }   
        
## Movie Detail [/movie/{movie_name}]

### See detail of an Movie [GET]

+ Parameters
    + movie_name (string) - Name of the Movie

+ Response 200 (application/json)

    + Body
            {
               "name": "Inception",
               "desc": "good movie",
               "rating": "4.0",
               "genre" :"Thriller",
               "actors": [
                    {
                        "bio": "Some guy",
                        "name": "Leonardo Dicaprio",
                        "age": "35.0"
                    }
                ]
            }

// Request a Movie that doesn't exist (e.g movie_name=Inception Two)       

+ Response 404 (Resource not found - application/json)





## Genres Collection [/genre]

### List All Genres and their movies [GET]

+ Request (application/json)

+ Response 200 (application/json)

       [
            {
                "name":"Thriller",
                "movies": [
                        {
                            "desc":"good movie",
                            "name":"Inception",
                            "rating":"4.0"
                        }
                    ]
            },
        ]
        
## Genre Detail [/genre/{genre_name}]

### See detail of a Genre [GET]

+ Parameters
    + genre_name (string) - Name of the Genre

+ Response 200 (application/json)

    + Body
            {
               "name": "Thriller",
               "actors": {
                    "Leonardo Dicaprio": {
                        "bio": "Some guy"
                    }
                },
                "movies": [
                    {
                        "genre":"Thriller",
                        "name":"Inception",
                        "desc":"good movie",
                        "rating":"4.0"
                    },
                ]
            }

// Request a Genre that doesn't exist (e.g genre_name=unknown genre)
           
+ Response 404 (Resource not found - application/json)

## Add Genre [/create/genre]

### Add a Genre to the database [POST]

-- Required fields: "name"

+ Request (application/json)
    + Body
    
            {
               "name" : "New Genre"
            }
            
+ Response 200 (application/json)

    + Body
            {
                "created" : true
            }
            
// Try to create a Genre without giving a name (required field)  
+ Request (application/json)
    
    + Body
            {
                "someRandomKey": "someValue"
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "name" : {
                    0 : "The name field is required."
                }
            }
            
            
// Try to create a genre that already exists            
+ Request (application/json)

    + Body
            {
                "name" : "Thriller", 
            }
            
+ Response 422 (Invalid form data entry - application/json)

    + Body
            {
                "genre" : {
                    0 : "The name has already been taken"
                }
            }
        





