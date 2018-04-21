# Chattier Social Network

Chatty social network from Codecourse tutorial rebuilt from scratch as a single-page app.

- Laravel 5.6
    - JWT-based authentication with token refreshing
- Vue.js 2
- Bulma
    - Buefy components
    - Bulmaswatch themes

## Demo

A live demo of this project can be found [here](https://raniesantos-chattier.herokuapp.com/?ref=github-readme).

## Setup

- Start your local server. (Laravel Homestead, XAMPP/WAMP/MAMP, etc.)
- `yarn install`
- `yarn dev`
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
