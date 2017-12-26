# Lumen REST API with MongoDB, OAuth2 and JSON API
- REST API boilerplate for Lumen micro-framework with MongoDB database. 
- Implements JSON API and OAuth2 authentication.
- Lightweight and super-fast due to leveraging PHP OPcache for caching data output.

## Installation

- `git clone https://github.com/elcobvg/rest-api-lumen.git`
- `cd rest-api-lumen`
- `cp .env.example .env`
- `composer install`
- Edit `.env` and set your MongoDB connection details
- `php artisan migrate`
- `php artisan passport:install`

### References
- [Lumen micro-framework](https://lumen.laravel.com/)
- [MongoDB](https://www.mongodb.com/)
- [JSON API](http://jsonapi.org/)
- [Laravel Passport](https://laravel.com/docs/5.5/passport)
 