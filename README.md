# ⚡️ Imóveis API + PHP + Laravel + Swagger API + Auth Sanctum + Docker + Redis + MySQL 🔥

This is a project to Imóveis with API REST

## Technologies and Tools

✔️ PHP 8.2\
✔️ Laravel 10\
✔️ Swagger API\
✔️ Redis\
✔️ Docker (Laradock or Sail)\
✔️ MySQL

## Project Setup

Setup With Docker Development:

```sh
docker-compose -f docker/docker-compose.yml up -d --build nginx php-fpm workspace mysql

```

Setup with Artisan

```sh
composer install

php artisan start
```

This application allows running processes in the background with laravel horizon or queue.

Setup With Docker:

```sh
docker-compose -f docker/docker-compose.yml up -d --build redis laravel-horizon // Laravel Horizon
//OR
docker-compose -f docker/docker-compose.yml up -d --build php-worker // Laravel Queues

```

Setup with Artisan

```sh
php artisan horizon // Laravel Horizon
// OR
php artisan queue:work --queue=upload_worksheet // Laravel Queues

```

## Documentation

In the main route`(/)` of this api there is a documentation made in Swagger with all the REST principles<br><br>

![Screenshot_317](https://user-images.githubusercontent.com/25870781/200200461-dc4ef672-0b45-450e-8506-ccfd372aafdc.png)

## Tests<br><br>

![Screenshot_318](https://user-images.githubusercontent.com/25870781/200200473-94f72493-d2a1-4cab-9137-dbcd4f0a2169.png)
