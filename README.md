# Laravel Tech Task Demo API

A Laravel RESTful API for managing tasks. With MongoDB as the database.

## Features

-   CRUD endpoints for tasks
-   Validation: name (3-100 chars), description (10-5000 chars)
-   Signed URLs for edit and delete actions
-   No authentication required
-   Uses MongoDB (NoSQL)
-   Soft deletes for tasks
-   All requests logged via middleware
-   Feature tests for all endpoints

## Endpoints

-   `GET    /api/tasks` — List all tasks
-   `POST   /api/tasks` — Create a new task
-   `GET    /api/tasks/{id}` — Show a single task
-   `PUT    /api/tasks/{id}` — Update a task (signed URL required)
-   `DELETE /api/tasks/{id}` — Delete a task (signed URL required)

## Setup

1. Clone the repository
2. Install dependencies:
    ```sh
    composer install
    ```
3. Set your MongoDB connection vars:
    ```env
    DB_CONNECTION=mongodb
    DB_DATABASE=task_api
    DB_URI=mongodb://localhost:27017
    ```
4. Run migrations:
    ```sh
    php artisan migrate
    ```
5. Start the server:
    ```sh
    php artisan serve
    ```

## Testing

-   Feature tests are in `tests/Feature/EndpointTest.php`.
-   To run tests:
    ```sh
    php artisan test --testsuite=Feature
    ```
-   Had issues with mongodb useRefresh on testing db so used a separate MongoDB database (see `.env.testing` or `phpunit.xml`).

## Bonus Points!

-   No user authentication is required.
-   All requests are logged via middleware.
-   Soft deletes are enabled for tasks.

---
