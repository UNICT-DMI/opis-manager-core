![image-20200620081023749](./docs/images/opis-manager-logo.png)





## Opis-manager-core 📊 

![CICD](https://github.com/UNICT-DMI/opis-manager-core/workflows/project%20build/badge.svg) 



Backend service for opis-manager project. Take a look at our [postman API documentation](https://explore.postman.com/templates/9736/opis-manager-core)!

### Getting started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

#### Prerequisites

You will need: 

* PHP 7.3+
* Composer
* php-xml
* php-mbstring
* php-mysql

In a debian-based you could install PHP 7.4 following [this guide](https://computingforgeeks.com/how-to-install-php-on-ubuntu/) and the related php extensions using:
```bash
sudo apt install php-xml php-mbstring php-mysql
```

#### Installing 

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



### Running the tests

This project uses phpunit with several Laravel testing features. In order to run tests, you must run: 

```sh
$ php artisan test
```

Or directly with phpunit:

```sh
$ vendor/bin/phpunit
```



### Deployment 

The recommended deployement setup is NGINX + php-fpm. Set up the project and link a virtual host to public/index.php. 

Cache configurations and routes for faster performances: 

```sh
$ php artisan config:cache
$ php artisan route:cache
```



### Built with

* Laravel 7 - the web framework used 
* Composer - Dependency management  



### Contributors 

* [Lemuel Puglisi](https://github.com/LemuelPuglisi)
