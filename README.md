# Laravel blog
A simple blog created using the Laravel framework.

## Installation
In order to use the application execute these commands in order:

````
npm install
````

````
composer install
````

Note: before going into production mode it is recommended to uninstall developer dependencies by running the following command:

````
composer install --no-dev
````

The next step is to change the database parameters inside the **.env** file.

When all is set the database can be migrated and seeded by executing the following commands:
````
php artisan migrate
````

````
php artisan db:seed
````