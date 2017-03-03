Instructions:

Run composer update

Next: Create a .env file, copy in the details from env.example

Next: Generate your APP_KEY with this command:

php artisan key:generate

Next: Create the Database by running this command:

touch database/database.sqlite

Run tests using the following command to verify everything was set up correctly:

./vendor/bin/phpunit

The test script will run the migrations and seeding for you.



