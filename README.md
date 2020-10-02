# Laravel Messanger Clone

[![N|Solid](https://abdullah-hejazi.dev/preview.JPG)](https://abdullah-hejazi.dev/preview.JPG)

Laravel Messanger Clone is a web app build using laravel to memic messanger application
This app is made for practicing purposes

### Features
  - Real Time Chat Messaging with sound alerts
  - Friend requests
  - Profile Pictures

# TODO

  - Add online/offline status for users (currently it's static)
  - Add more settings
  - Add change theme color option
  - Add Typing status for the users


# How to install and run
```sh
$ git clone https://github.com/Abdullah-Hejazi/laravel-messenger-clone.git
$ cd laravel-messenger-clone
$ composer install
$ cp .env.example .env
$ php artisan migrate
$ php artisan key:gen
$ php artisan serve && php artisan websockets:serve
```

#### This code does implement Laravel-Websockets
Since this code is depenedent on laravel-websockets package, be sure to check out its docs to edit all the options:
https://beyondco.de/docs/laravel-websockets/getting-started/introduction


# Good luck