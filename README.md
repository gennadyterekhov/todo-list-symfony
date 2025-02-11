# todo list app on symfony

no auth needed  
endpoints  

- GET /api/tasks 

- GET /api/tasks/{id} 

- POST /api/tasks

- PUT /api/tasks/{id} 

- DELETE /api/tasks/{id}

also see this [postman collection](https://github.com/gennadyterekhov/todo-list-symfony/blob/main/docs/postman_collection.json)


# how to run

## build

start containers

    docker compose up

install dependencies

    docker compose exec php-fpm composer install

run migrations

    docker compose exec php-fpm php bin/console do:mi:mi

## run

to run with local test db

    docker compose -f compose.yml -f local.yml up

don't forget to run migrations for test env

    docker compose exec php-fpm php bin/console do:mi:mi --env=test


# tests

(make sure you have `db-test` service running)

    docker compose exec php-fpm php bin/phpunit