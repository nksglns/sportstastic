# Sportstastic
A code challenge for a small sports dashboard. Please use PHP version 7.4+ in order to setup and run this project.

# Setup instructions

First install composer dependencies.

```bash
$ composer install
```

Create a new `.env` file from `.env.example` and replace the database configuration (all the DB_ variables).

Run the migrations

```bash
$ php artisan migrate
```
Run the database import command. This might take a while. This can also be used in the /app/Console/Kernel.php to setup a periodical update.
Possible errors will be logged at laravel's error log.

```bash
$ php artisan sportdata:fetch
```

Go to the public directory, and run the following command to symlink the public directory

```bash
$ ln -s ../storage/app/public public
```
Or on windows via cmd
```bash
mklink /D public ..\storage\app\public
```

Go back to the root of the project, install the required npm dependencies and build the assets

```bash
$ npm install
```
```bash
$ npm run production
```

Finally, run the artisan serve command and open localhost:8000 in your local browser

```bash
$ php artisan serve
```
