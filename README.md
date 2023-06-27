# Weather Management System
A weather application that allows users to favourite locations for weather reports

## Important Notes
- This project uses my personal admin system - [Laravel TVI](https://github.com/LiamThursfield/Laravel-TVI) - as a base for the admin panel. This is to save time on the project and to allow me to focus on the weather application. 
- This project is setup to use Laravel Sail for local development. If you do not have Docker installed, please follow the instructions [here](https://laravel.com/docs/10.x/sail#installation) to install it.

## Getting Started
This project is setup to use Laravel Sail for local development. To get started, run the following commands:
```
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail yarn
./vendor/bin/sail yarn dev
```

To generate a super-user account, run the following command:
```
./vendor/bin/sail artisan user:create-super
```

## Running Tests
To run the tests, run the following command:
```
./vendor/bin/sail artisan test
```
