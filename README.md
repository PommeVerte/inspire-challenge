# Dealer Inspire Challenge
Thank you for taking the time to review my submission. 

I know the team uses Laravel on one (some?) of the projects, so I decided to use Laravel for this challenge.

### Setup
There are a few simple steps to get up and running 

```shell script
composer install

cp .env.example .env

php artisan key:generate

php artisan test # or ./vendor/bin/phpunit
``` 

Although the unit tests work out of the box (sqlite is required), you'll need to configure a couple of services to ensure the app/site is fully functional:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/db/file
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_USERNAME=root
#DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
```
*uncomment as needed.*

Once the configuration is good you can 
````shell script
php artisan migrate
php artisan serve
```
