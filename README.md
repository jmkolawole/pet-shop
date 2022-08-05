## PETSHOP API

This is a project to create an api for on online petshop.

## :heavy_check_mark: Getting Started
Prior to cloning this project, have a good understanding of how the API works generally. These instructions 
will get a copy of the project up and running on your local machine for development and testing purposes. The application uses a single database

## :rocket: Installation

#### Clone the project

Via SSH (recommended):
```
git clone git@github.com:jmkolawole/pet-shop.git
```
*Note that to use SSH, you'll need to [generate an SSH key](https://git-scm.com/book/en/v2/Git-on-the-Server-Generating-Your-SSH-Public-Key) and [add it to your Gitlab account](https://docs.gitlab.com/ee/ssh/README.html#adding-an-ssh-key-to-your-gitlab-account).*

Or via HTTPS:
```
git clone https://github.com/jmkolawole/pet-shop.git
```

#### Install Dependencies With Composer
*Note that this Project uses Laravel 9 and requires PHP 8.0 and the latest composer version
Change directory to your project folder and run:
```
composer install
```

#### Setup Environment Configuration
Create a _.env_ file from _.env.example_ file provided in the cloned project
```
cp .env.example .env
```
Create a _.env.testing_ file from _.env.testing.example_ file provided in the cloned project
```
cp .env.testing.example .env.testing
```

Set up your Local database connection and update all env files that you need to update

#### Generate App Key
```
php artisan key:generate
```

#### Run Migration and Seeders for petshop api

```
php artisan migrate --seed
```

Cheers! You have successfully setup petshop API on your local machine.
:+1: :+1: :+1:


## :package: Built With

* [Laravel](http://laravel.com/docs/)
* [Composer](https://getcomposer.org/)

## :handshake: Developer

API Version 1
- JIMOH Mofoluwasho Kolawole

