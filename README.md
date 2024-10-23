# FormBuilder

A Laravel Filament project for creating and managing forms dynamically.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)

## Installation

1. **Clone the repository:**
   
git clone https://github.com/Redouane-KHALDI/formbuilder.git

cd formbuilder

Install dependencies: 

composer install

npm install

Set up your environment:

Copy the .env.example file to .env:

Generate the application key:

php artisan key:generate

Create your database :

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=formbuilder
DB_USERNAME=root

Run migrations:

php artisan migrate:fresh --seed

This will create some countries and admin access

Start the development server:

php artisan serve

## usage

Access the application at http://localhost:8000

list of forms by country to register: http://localhost:8000

to login as admin : http://localhost:8000/login

use this login access for admin

email : admin@payd.io

password : admin

To login as user registred by form: http://localhost:8000/users/login

The user will be automaticaly redirected to his dashboard after registration


## Features:

Dynamic form creation and management.

User-friendly interface powered by Laravel Filament.

Validation and error handling for form submissions.

Support for various field types (text, dropdown, radio, etc.).