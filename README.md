# DDD php Skeleton

## Installation

`composer install`

## Usage

`docker-compose up -d --build`

`curl http://localhost:8030/health-check`

### Subscribers

`docker-compose exec php php apps/mooc/backend/bin/console luiscusihuaman:mysql:consume <quantityEventsToProcess>`

## Tests

`docker-compose exec php vendor/bin/phpunit`

`docker-compose exec php vendor/bin/behat -p mooc_backend`

