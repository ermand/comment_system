# Comment System - Ermand Durro

## Requirements
- PHP >= 5.4.0
- composer


## How to install
This projects uses composer for autoloading and psr-4.

- Step 1:
    Extract zip file and move it into web server's root folder. Example: Apache's root folder is www.

- Step 2:
    Open terminal on extracted folder and run: composer install or composer update.

- Step 3:
    Change config.php file to your database credentials. Then create a database with name: comment_system

- Step 4:
    Run sql file: `comment_system_2014-11-01.sql` in order to create `posts` & `comments` tables.

- Step 5:
    open application on browser.


## Application structure.

    public\
        css\
        js\
    src\
        Controllers\
        Models\
        Repositories\
        Services\
        Views\
