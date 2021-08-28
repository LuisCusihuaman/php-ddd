# PHP-DDD

## Installation

`composer install`

## Usage

`docker-compose up -d --build`

`curl http://localhost:8030/health-check`

### Commands

`docker-compose exec php apps/mooc/backend/bin/console`

```shell
docker-compose exec php apps/mooc/backend/bin/console luiscusihuaman:mysql:consume <quantityEventsToProcess>
docker-compose exec php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:configure
docker-compose exec php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:consume <queueName> <quantityEventsToProcess>
docker-compose exec php apps/mooc/backend/bin/console luiscusihuaman:rabbitmq:generate-supervisor-files <OPT: path>
```

## Tests

`docker-compose exec php vendor/bin/phpunit`

`docker-compose exec php vendor/bin/behat -p mooc_backend`

