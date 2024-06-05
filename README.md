# Optimy PHP Exam
Exam Submission by Dexter Loor (dexter.loor@gmail.com) for the position of Sr. PHP Developer

## Requirements:
- PHP v8.1 or higher
- MySQL v5.7 or higher
- Composer

Note: If you do not have composer installed globally, follow these instructions:

- Download Composer: https://getcomposer.org/download/
- After running the installer following the Download page instructions you can run this to move composer.phar to a directory that is in your path:
`mv composer.phar /usr/local/bin/composer`
- Check this page for more information: https://getcomposer.org/doc/00-intro.md

## How to run the exam output:
1. Clone the repository
2. cd to the repository directory
3. Run `composer install`
4. Update the Database credential values found in config/doctrine.yaml 
   - user: // username of your MySQL database 
   - password: // password of your MySQL database 
   - dbname: // name of your MySQL database 
   - host: // server URL/host of your MySQL database, typically 127.0.0.1 for localhost 
   - port: // port of your MySQL database, typically 3306
5. Create the schema for your database by running this command: `bin/console orm:schema-tool:create`
6. Load the sample data (fixtures) for the newly created schema by running this command: `bin/console doctrine:fixtures:load`
7. Execute PHPUnit Tests to make sure all are working correctly by running this command: `vendor/bin/phpunit`
8. To check the exam output, run this command from the terminal: `php index.php`

## Quick Documentation

### Packages used:
1. `doctrine/orm` - this is used for managing database connection, Entities, methods (SELECT, INSERT, UPDATE, DELETE, etc)
2. `doctrine/dbal` - required for setting up database configurations via a driver.
3. `symfony/yaml` - to set up and get database credentials and other properties from doctrine.yaml configuration
4. `doctrine/migrations` - to manage migrations whenever there are changes in the database Entities. This also provides the commands necessary to automatically create or update the database schema
5. `symfony/cache` - required dependency for doctrine/migrations commands to run

### Dev-only Packages:
1. `doctrine/data-fixtures` - used to pre-populate database table entries
2. `phpunit/phpunit` - used for writing and executing unit tests for PHP classes

### Initializing the EntityManager (in bootstrap.php)
1. This project uses an instance of the EntityManager Interface to access database methods like SELECT, INSERT, UPDATE, DELETE
2. The EntityManager is initialized to connect to our defined database in bootstrap.php

### Commands (in bin/console)
1. The schema creation command, `bin/console orm:schema-tool:create` is defined in `bin/console` to enable automatic creation/updating of database tables whenever there are updates in the Entities defined in src/Entity
2. Same is true with the fixtures load command, `bin/console doctrine:fixtures:load`

### Entities and Repositories
1. Database tables are represented as Entities under `src/Entity`.
2. Repository classes are mapped together with its corresponding Entity class in `src/Repository` where custom queries and fetch methods can be defined.

### Data Transfer Objects
To manage the creation of Entity objects (e.g. News) such as when inserting new entries to the database, this project utilizes DTOs or Data Transfer Objects (found in `src/DTO`) which is a model containing properties that represent expected input values (e.g. coming from a form)

To map DTOs into actual Entity objects, this app also uses DTOMapper classes (found in `src/DTOMapper`) to map DTO properties into Entity Object properties.

### Service Classes
Each class under src/Service represents methods that can be used by the `index.php`. Methods for News and Comment include:
   - Get All
   - Get By ID or Primary Key
   - Create One item
   - Delete One item

### Utility Functions
Functions for rendering / displaying the result of Service Class methods can be found in `src/Utility/Utils.php`

### index.php
This is the executable script that utilizes the Service Classes and Utils for displaying the desired output.