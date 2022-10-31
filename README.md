<h1 align="center">OPIS manager core 🫀</h1>
<p>
</p>

<p align="center">
    Backend service for opis-manager project. Take a look at our <a href="https://explore.postman.com/templates/9736/opis-manager-core"> postman documentation 
</p>

<p align="center">
    <img src="https://github.com/UNICT-DMI/opis-manager-core/workflows/project%20build/badge.svg" />
    <a href="https://www.codefactor.io/repository/github/unict-dmi/opis-manager-core"><img src="https://www.codefactor.io/repository/github/unict-dmi/opis-manager-core/badge" alt="CodeFactor" /></a>    
</p>

## Getting started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Install PHP 7.3+, composer and some php extensions: php-xml, php-mbstring, php-mysql, php-sqlite3.

### Installation 

Clone the repository

```sh
$ git clone https://github.com/UNICT-DMI/opis-manager-core.git
```

Copy the example enviroment file in a valid .env

```sh
$ cp .env.example .env
```

Opis-manager database is quite agnostic to the database driver under the hood, so configure it in .env. 

```sh
DB_CONNECTION=(database driver)
DB_HOST=(database host server)
DB_PORT=(database port)
DB_DATABASE=(database name)
DB_USERNAME=(database user)
DB_PASSWORD=(database user password)
```

Install project dependencies 

```sh
$ composer install
```
Set an application encryption key

```sh
$ php artisan key:generate
```

Generate a JWT secret

```sh
$ php artisan jwt:secret
```

Migrate the database schema

```bash
$ php artisan migrate
```

You can actually use seeders to fill the database with existing data. 

```bash
$ php artisan db:seed
```

Start a local web server: 

```sh
$ php artisan serve
```



## Running the tests

This project uses phpunit with several Laravel testing features. In order to run tests, you must run: 

```sh
$ php artisan test
```

Or directly with phpunit:

```sh
$ vendor/bin/phpunit
```



## Deployment 

The recommended deployement setup is NGINX + php-fpm. Set up the project and link a virtual host to public/index.php. 

Cache configurations and routes for faster performances: 

```sh
$ php artisan config:cache
$ php artisan route:cache
```

## Docker Compose

Configure the .env file using as `DB_HOST=db`, keep the variable`DB_PASSWORD=` empty.

Run the following commands to deploy the project on docker. This is going to deploy two services: 

```sh
docker-compose up
```

You can check if the application is running on http://127.0.0.1:8080/ but keep in mind that you need to insert a database into the current mysql db container.

### Built with

* Laravel 8 - the web framework used 
* Composer - Dependency management  



### Contributors 

* [Lemuel Puglisi](https://github.com/LemuelPuglisi)
