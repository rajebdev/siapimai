# ![Laravel SIAPIMAI App]

> ### Laravel codebase containing real world examples (CRUD, auth, advanced patterns and more) that adheres to the [SIAPIMAI](https://github.com/https://github.com/rajebdev/siapimai) spec and API.

----------

# To-Do List
* [x] Membuat flow diagram / usecase diagram sederhana
* [x] Membuat repo git baru dari project yang sudah anda kerjakan
* [x] Absen masuk dan keluar menggunakan geo-tagging dari tempat tertentu
* [ ] Laporan ditampilkan dalam bentuk dashboard grafik
* [x] User leveling login and access with sanctum and custom middleware
* [x] API Backend 90%
* [ ] WEB Frontend 50%


# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x#installation-via-composer)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone git@github.com:rajebdev/siapimai.git

Switch to the repo folder

    cd siapimai

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:rajebdev/siapimai.git
    cd siapimai
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## API Specification

This application adheres to the api specifications set by the [rajebdev](https://github.com/rajebdev). This helps mix and match any backend with any other frontend without conflicts.

- POST  `/api/login` - for login to system
- POST  `/api/register` - for register to system
- POST  `/api/logout` - for logout from system
- POST  `/api/users` - for store data user
- GET   `/api/users/my` - for call user data only logged
- GET   `/api/users/all` - for call all user data
- GET   `/api/users/{user}` - for show data user
- PUT   `/api/users/{user}` - for update data user
- POST  `/api/attendes` - for store data attende
- GET   `/api/attendes/my` - for call attende data only logged
- GET   `/api/attendes/all` - for call all attende data
- GET   `/api/attendes/{attende}` - for show data attende
- PUT   `/api/attendes/{attende}` - for update data attende
- POST  `/api/permissions` - for store data permission
- GET   `/api/permissions/my` - for call permission data only logged
- GET   `/api/permissions/all` - for call all permission data
- GET   `/api/permissions/{permission}` - for show data permission
- PUT   `/api/permissions/{permission}` - for update data permission
- POST  `api/permissions/approve/{permissions}` - for approve permission request

More information regarding the project can be found here https://github.com/rajebdev/siapimai

----------

# Code overview

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/API` - Contains all the api controllers
- `app/Http/Controllers/WEB` - Contains all the web controllers
- `app/Models/` - Contains all the table models
- `app/Http/Middleware` - Contains auth middleware
- `config` - Contains all the application configuration files
- `resources/view` - Contains all the view applicationfiles
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes/api.php` - Contains all the api routes defined in api.php file
- `routes/web.php` - Contains all the web routes defined in web.php file
- `public` - Contains all the web assets used

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|

Refer the [api specification](#api-specification) for more info.

----------

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors