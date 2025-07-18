# Products API Project

A minimal API project for imaginary products with CRUD operations, built on Laravel + Inertia + Vue starter kit, featuring comprehensive API documentation, validation, error handling, and testing.

## Project Overview

This project implements a RESTful API for managing products. It includes:

- Product model with fields for name, description, price, stock, and active status
- API endpoints for CRUD operations (Create, Read, Update, Delete)
- Validation and error handling
- Sample data by using seeders
- Test script for API endpoints
- Comprehensive API documentation

## Setup Instructions

1. Clone the repository
2. Install dependencies:
   ```
   composer install
   npm install
   ```
3. Set up the environment:
   ```
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations and seeders:
   ```
   php artisan migrate:fresh --seed
   ```
5. Start the development server:
   ```
   php artisan serve
   ```

## API Endpoints

The following API endpoints are available:

- `GET /api/products` - List all products
- `GET /api/products/{id}` - Get a specific product
- `POST /api/products` - Create a new product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

For detailed information about request parameters and response formats, see the [API Documentation](API_DOCUMENTATION.md).

## Testing the API
To test the API endpoints, you can use tools like Postman. Below are examples of how to interact with the API:

### Automated Testing with Pest

The project includes automated feature tests using Pest:

1. Run the tests:
   ```
   php artisan test
   ```

The Pest tests cover all CRUD operations for the Products API:
- Listing all products
- Getting a single product
- Creating a product (including validation)
- Updating a product
- Deleting a product
- Error handling for non-existent products

## Project Structure

- `app/Models/Product.php` - Product model
- `app/Http/Controllers/Api/ProductController.php` - Controller for product API endpoints
- `database/migrations/2025_07_18_065717_create_products_table.php` - Migration for products table
- `database/seeders/ProductSeeder.php` - Seeder for sample product data
- `routes/api.php` - API routes
- `tests/Feature/ProductApiTest.php` - Pest tests for API endpoints
- `API_DOCUMENTATION.md` - Detailed API documentation

## Features

- **Product Management**: Create, read, update, and delete products
- **Validation**: Input validation for product fields
- **Error Handling**: Proper error responses with meaningful messages
- **Sample Data**: Seeder for creating sample products
- **Testing**:
  - Automated tests using Pest for all CRUD operations
- **Documentation**: Comprehensive API documentation