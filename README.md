# DDD php Skeleton

## Installation

`composer install`

## Usage

`make start-local`

`docker-compose up -d --build`

`php apps/mooc/backend/bin/console luiscusihuaman:consume-domain-events:mysql <quantityEventsToProcess>`

`curl http://localhost:8030/health-check`

## Tests

`docker-compose exec php vendor/bin/phpunit`

`docker-compose exec php vendor/bin/behat -p mooc_backend`

