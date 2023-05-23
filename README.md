# era-biz-laravel-task

A single restful endpoint for managing product

## Dependencies

Docker, Docker Compose

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
    2. docker exec era_biz_php_fpm cp .env.example .env
    3. docker exec era_biz_php_fpm php artisan migrate:fresh --seed
```

6. After establishing and running docker env on your machine access the app from this url

```
    http://localhost:8080/
```

Cooool !!! Now the application is ready to use.

7. Import the postman collection from the project root to test the app with postman.

```
    EraBiz Collection.postman_collection.json
```

## Testing

API tests are written for the products end points. In order to run it try follwing commands.

```
    docker exec era_biz_php_fpm php artisan test
```

Mind that after running tests, the database is refreshed.

## Tech Stack

This app iss running on a Docker Environment and has used following tech stack.

```
    PHP 8.2, Laravel 10, PosgreSQL, Docker
```

## Design and Trade-offs

1. Assuming that the ReCaptcha token has come from the front-end user, and the endpoint has been added to verify the token.
2. Instead of device name (token name from front end), a configuration has been added to .env file to generate API token for sanctum.
    ```
        AUTH_TOKEN_NAME=era_biz_app
    ```
3. Default filters have been added to search by product name, description and price between two values.
4. Products can be sorted by using sory_by_name and sort_by_price.
5. In order to and new filters and sorting mechanism please check the following class.
6. More exceptions can be handled using app/Exceptions/Handler.php , Fore the moment Not Found Execption is the one only handled.
7. API tests written for products for basic functionalities. You can add more advanced tests.

```
    app/Filters/ProductFilter.php
```

You can extend the ProductFilter class and make your own Filter class to do modification
to adhere to the SOLID principles.

## Configurations

To change the Google Verification V3 keys and secrets, use the .env file and modify the following keys.

```
GOOGLE_RECAPTCHA_KEY=6LfWVCwmAAAAAOZeQB1Ulyumt2zTlGzyXq50NHKa
GOOGLE_RECAPTCHA_SECRET=6LfWVCwmAAAAAIc9W3t81nLp_cWVcKHoUqKuJv0M
```

To change the Pagination limit and Auth token name. check this.

```
PAGINATION_LIMIT=10
AUTH_TOKEN_NAME=era_biz_app
```

## List of Deliverables

1. Products Endoints.
2. ReCaptcha token verification endpoint.
3. Sanctum authentication endpoints.
