# Products API Documentation

This document provides information about the Products API endpoints, request parameters, and response formats.

## Base URL

All API endpoints are relative to the base URL:

```
http://localhost:8000/api
```

## Authentication

For the project scope, the API endpoints do not require authentication. This is suitable for the demonstrative environment. In a production environment, implementing authentication and authorization mechanisms (like API tokens or OAuth) is highly recommended to secure the endpoints.

## Endpoints

### List All Products

Retrieves a list of all products.

- **URL**: `/products`
- **Method**: `GET`
- **URL Parameters**: None
- **Data Parameters**: None

#### Success Response

- **Code**: 200 OK
- **Content**:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Smartphone X",
      "description": "Latest smartphone with advanced features",
      "price": "999.99",
      "stock": 50,
      "is_active": true,
      "created_at": "2025-07-18T06:57:17.000000Z",
      "updated_at": "2025-07-18T06:57:17.000000Z"
    },
    {
      "id": 2,
      "name": "Laptop Pro",
      "description": "High-performance laptop for professionals",
      "price": "1499.99",
      "stock": 30,
      "is_active": true,
      "created_at": "2025-07-18T06:57:17.000000Z",
      "updated_at": "2025-07-18T06:57:17.000000Z"
    }
  ]
}
```

### Get a Specific Product

Retrieves a specific product by ID.

- **URL**: `/products/{id}`
- **Method**: `GET`
- **URL Parameters**: 
  - `id`: The ID of the product to retrieve

#### Success Response

- **Code**: 200 OK
- **Content**:

```json
{
  "data": {
    "id": 1,
    "name": "Smartphone X",
    "description": "Latest smartphone with advanced features",
    "price": "999.99",
    "stock": 50,
    "is_active": true,
    "created_at": "2025-07-18T06:57:17.000000Z",
    "updated_at": "2025-07-18T06:57:17.000000Z"
  }
}
```

#### Error Response

- **Code**: 404 Not Found
- **Content**:

```json
{
  "message": "Product not found",
  "error": "No query results for model [App\\Models\\Product] 1"
}
```

### Create a Product

Creates a new product.

- **URL**: `/products`
- **Method**: `POST`
- **Headers**:
  - Content-Type: application/json
- **Data Parameters**:

```json
{
  "name": "New Product",
  "description": "Description of the new product",
  "price": 99.99,
  "stock": 100,
  "is_active": true
}
```

#### Required Fields

- `name`: String, max 255 characters
- `price`: Numeric, minimum 0
- `stock`: Integer, minimum 0

#### Optional Fields

- `description`: String, can be null
- `is_active`: Boolean, defaults to true

#### Success Response

- **Code**: 201 Created
- **Content**:

```json
{
  "message": "Product created successfully",
  "data": {
    "id": 7,
    "name": "New Product",
    "description": "Description of the new product",
    "price": "99.99",
    "stock": 100,
    "is_active": true,
    "created_at": "2025-07-18T07:30:00.000000Z",
    "updated_at": "2025-07-18T07:30:00.000000Z"
  }
}
```

#### Error Response

- **Code**: 422 Unprocessable Entity
- **Content**:

```json
{
  "message": "Validation failed",
  "errors": {
    "name": [
      "The name field is required."
    ],
    "price": [
      "The price field is required."
    ],
    "stock": [
      "The stock field is required."
    ]
  }
}
```

### Update a Product

Updates an existing product.

- **URL**: `/products/{id}`
- **Method**: `PUT`
- **URL Parameters**:
  - `id`: The ID of the product to update
- **Headers**:
  - Content-Type: application/json
- **Data Parameters**:

```json
{
  "name": "Updated Product Name",
  "price": 149.99,
  "stock": 75
}
```

#### Fields

All fields are optional for updates. Only include the fields you want to update.

#### Success Response

- **Code**: 200 OK
- **Content**:

```json
{
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "name": "Updated Product Name",
    "description": "Latest smartphone with advanced features",
    "price": "149.99",
    "stock": 75,
    "is_active": true,
    "created_at": "2025-07-18T06:57:17.000000Z",
    "updated_at": "2025-07-18T07:35:00.000000Z"
  }
}
```

#### Error Response

- **Code**: 404 Not Found
- **Content**:

```json
{
  "message": "Product not found or failed to update",
  "error": "No query results for model [App\\Models\\Product] 999"
}
```

### Delete a Product

Deletes a specific product.

- **URL**: `/products/{id}`
- **Method**: `DELETE`
- **URL Parameters**:
  - `id`: The ID of the product to delete

#### Success Response

- **Code**: 200 OK
- **Content**:

```json
{
  "message": "Product deleted successfully"
}
```

#### Error Response

- **Code**: 404 Not Found
- **Content**:

```json
{
  "message": "Product not found or failed to delete",
  "error": "No query results for model [App\\Models\\Product] 999"
}
```

## Testing the API

A Feature Pest test is provided in the repository to test all the API endpoints. To use it:

1. Start the Laravel development server:
   ```
   php artisan serve
   ```

2. Run the database migrations and seeders to set up the database with sample data:
   ```
   php artisan migrate:fresh --seed
   ```

3. Run the tests using Pest:
   ```
   php artisan test
   ```

Pest will test all the API endpoints and display the responses.