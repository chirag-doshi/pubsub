
## About PubSub

PubSub is a small api app for publishing and subscribing built on laravel

## Setup

- ```git clone``` the repository
- Make sure nginx, php and mysql is setup on the client machine
- Setup composer
- Install laravel installer globally - ```composer global require laravel/installer```
- From the mysql console or mysql client create a new database call it ``pangea``
- In the .env file update the ``DB_Password=`` to ``DB_Password=YourMysqlPassword`` add the actual password
- Migrate the database ```php artisan migrate```
- Run ```php artisan serve ``` this will enable the application to be run from http://localhost:8000
    - or run the bash script ./start-server.sh

## Available endpoints

- POST /subscribe/{TOPIC}

    BODY {url: "http://localhost:3000/event"}
    
    The above code would create a subscription for all events of {TOPIC} and forward data to http://localhost:3000/event
- POST /publish{TOPIC}

    BODY {"message" : "hello" }
    
    The above code would publish on whatever is passed in the body (as JSON) to the supplied topic in the URL. This endpoint should trigger a forwarding of the data in the body to all of the currently subscribed URL's for that topic.

## Event endpoint
- The ``/event`` endpoint has been created but the post data received would show in app->storage->logs->laravel.log
## Unit Tests
- Unit tests can be run from the root directory with command ```phpunit```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
