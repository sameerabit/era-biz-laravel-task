# era-biz-laravel-task

A single restful endpoint for managing product

## Dependencies

Docker should be there on your machine.

## How to run this application

1. Clone the project

2. Go to terminal and find and go to the project path

3. Now, run the follwing commands in your terminal

```
    cd docker
    docker-compose up --build
```

4. Open a new terminal window or tab

5. Run docker ps command and find the container name

6. Run the following command on your container

```
    1. docker exec era_biz_php_fpm composer install
    2. docker exec era_biz_php_fpm php artisan migrate:fresh --seed
```

6. After establishing and running docker env on your machine access the app from this url

```
    http://localhost:8080/
```

Cooool !!! Now the application is ready to use.

7. Import the postman collection from the project root.

```
    https://github.com/sameerabit/era-biz-laravel-task
```

8. API tests are written for the products end points. In order to run it try follwing commands.

```
    docker exec era_biz_php_fpm php artisan test
```
