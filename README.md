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

```bash
$ php artisan sportdata:fetch
```

Go to the public directory, and run the following command to link the public directory

```bash
$ ln -s ../storage/app/public public
```
Or on windows via cmd
```bash
mklink /D public ..\storage\app\public
```
