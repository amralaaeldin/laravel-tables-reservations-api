# Laravel Tables Reservations API

This is a Laravel-based api that allows you to CRUD tables reservations & orders.

## Features

-   **Check Availability**: check if a table is available during certain date, for the number of guests.
-   **Reserve Table**: reserve table for customer in the date time he requested.
-   **List All Items in Menu**: list all items in menu (assumed that restaurant can only serve every meal limited times per day).
-   **Order**: place an order for a table applying all discounts for each meal.
-   **Checkout and Print Invoice**: checkout and print invoice for a table reservation.
-   **Waiting List**: put customers on waiting list if maximum capacity of tables reached.

## Requirements

-   PHP 8.0 or higher
-   Composer
-   MySQL (or any other database)
-   Docker (optional)

## Installation

### Without Docker

#### Step 1: Clone the Repository & Install Dependencies

Clone the repository to your local machine:

```bash
git clone https://github.com/amralaaeldin/laravel-tables-reservations-api
cd laravel-tables-reservations-api
composer install
cp .env.example .env
```

#### Step 2: Define Environment Variables

Open the .env file and configure your environment variables.

#### Step 3: Generate an Application Key & Set Up the App

Run the following command to generate an application key:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed //optional
```

#### Step 4: Start the Development Server

You can start the development server using the following command:

```bash
php artisan serve
```

### With Docker

#### Step 1: Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/amralaaeldin/laravel-tables-reservations-api
cd laravel-tables-reservations-api
```

#### Step 2: Build the Docker Image using Docker Compose

Build the Docker image using the following command:

```bash
docker-compose build
```

#### Step 3: Start the Docker Containers

Start the Docker containers using the following command:

```bash
docker-compose up -d
```

#### Step 4: Install Composer Dependencies

Install the Composer dependencies inside the PHP container:

```bash
docker-compose exec app composer install
```

#### Step 5: Generate an Application Key & Set Up the App

Generate an application key using the
following command:

```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed //optional
```

#### Step 6: Start the Development Server

You can access the application at `http://localhost:8000`.

## Troubleshooting

If you run into issues:

-   Ensure Docker is running if you're using Docker.
-   Check the Laravel logs (storage/logs/laravel.log) for detailed error messages.
-   Make sure you have the correct file permissions if you're running on a local system.
-   Check your .env file for any configuration mistakes (like the wrong database credentials).
