
Requirements
PHP 8.1.0 or higher;
and the usual Symfony application requirements.

Installation

Option 1. Download Symfony CLI and use the symfony binary installed on your computer to run this command:

$ symfony new --demo my_project
Option 2. Download Composer and use the composer binary installed on your computer to run these commands:

# you can create a new project based on the Symfony Demo project...
$ composer create-project symfony/symfony-demo my_project

# ...or you can clone the code repository and install its dependencies
$ git clone https://github.com/symfony/demo.git my_project
$ cd my_project/
$ composer install


Usage
There's no need to configure anything before running the application. There are 2 different ways of running this application depending on your needs:

Option 1. Download Symfony CLI and run this command:

$ cd my_project/
$ symfony serve
Then access the application in your browser at the given URL (https://localhost:8000 by default).

Option 2. Use a web server like Nginx or Apache to run the application (read the documentation about configuring a web server for Symfony).

On your local machine, you can run this command to use the built-in PHP web server:

$ cd my_project/
$ php -S localhost:8000 -t public/
Tests
Execute this command to run tests:

$ cd my_project/
$ ./bin/phpunit
