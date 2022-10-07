## Installation

- git clone https://git.kolsanovafit.ru/kolsanovafit/back-video/
- cd back-video
- composer install
- cp .env.example .env
- chmod -R 777 storage
- create empty DB and set DB settings in .env
- php artisan key:generate
- php artisan migrate
- php artisan l5-swagger:generate (docs URL: /api/documentation)

#### Run test
- !!! for every command that you run from command line for testing DB you need to add ```--env=testing``` option
- copy ```.env.testing.example``` to ```.env.testing``` add need settings like email, database connection
- run key generation ```php artisan key:generate --env=testing```
- run migrations if need ```php artisan migrate --env=testing```
- run test with command ```php artisan test --env=testing```
