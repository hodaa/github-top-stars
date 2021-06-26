## GitHub Repos
A list of the most popular repositories, sorted by number of stars. You are able to view the top 10, 50.

## Installation
* `cp .env.example .env`  
  
* Put this in your .env
  
   * API_URL=https://api.github.com/search/repositories
   * GITHUB_TOKEN=your token 
   * API_CREATED_AT=2019-01-01
    
* `docker-compose up -d` 

From PHP image
* `docker-compose exec php bash`
    * `composer install`
    * `php artisan key:generate`


    
## Usage
http://localhost:8080/api/v1/repos

_**ex:**_
http://localhost:8080/api/v1/Repos?language=php&per_page=10


## CLI

php artisan repos:fetch

_**ex:**_
* php artisan repos:fetch per_page:10 language:php
* php artisan repos:fetch created:2020-01-01


## Testing
From PHP image
* `docker-compose exec php bash`
  
Run

    vendor/phpunit/bin


## Tools
* PHP7.4
* Laravel
* Docker
* phpunit












    
