# Chattier Social Network

Chatty social network from Codecourse tutorial rebuilt from scratch as a single-page app using Laravel 5.6 and Vue.js 2.

## Setup

- Start your local server. (Laravel Homestead, XAMPP/WAMP/MAMP, etc.)
- `yarn install` or `npm install` (Yarn recommended)
- `yarn run dev` or `npm run dev`
- `composer install`
- configure `.env` file based on `.env.example`
- configure database
- configure Mailtrap
- `php artisan key:generate`
- `php artisan jwt:secret`
- `php artisan migrate --seed`

## About the email addresses in the seeders

The emails used in the users seeder are all publicly available emails displayed on either GitHub or social media profiles.

The reason I collected and used these emails was because I wanted all of my dummy users to have Gravatar images.

This app is configured to use Mailtrap and will not send any unwanted emails to these accounts.
