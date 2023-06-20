
Backend API REST project for Web application for an electric motorcycle company
## Requirements
PHP 8.1.0 or higher;
and the usual Symfony application requirements.

## Installation

Option 1. Download Symfony CLI and use the symfony binary installed on your computer to run this command:

`symfony new api.local`
Option 2. Download Composer and use the composer binary installed on your computer to run these commands:

you can create a new project...
`composer create-project api.local`

...or you can clone the code repository and install its dependencies
`git clone https://github.com/CarolinaParraga/api.local.git`
`composer install`

## Database create and migration

`php bin/console doctrine:database:create`
`php bin/console doctrine:migrations:diff`
`php bin/console doctrine:migrations:migrate`

## Usage
There's no need to configure anything before running the application. There are 2 different ways of running this application depending on your needs:

Option 1. Download Symfony CLI and run this command:

`cd my_project/`
`symfony serve`
Then access the application in your browser at the given URL (https://localhost:8000 by default).

Option 2. Use a web server like Nginx or Apache to run the application (read the documentation about configuring a web server for Symfony).

On your local machine, you can run this command to use the built-in PHP web server:

`cd my_project/`
`php -S localhost:8000 -t public/`

## Tests
Execute this command to run tests:

`cd my_project/`
`./bin/phpunit`
