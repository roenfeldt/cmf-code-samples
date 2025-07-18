<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** * Test the Product API endpoints.
 *
 * This test suite covers the basic CRUD operations for the Product model,
 * including listing all products, retrieving a single product, creating,
 * updating, and deleting products.
 */

/** * Set up the test environment before each test.
 *
 * This function creates two test products in the database to be used
 * in the tests.
 */
beforeEach(function (): void
{
    // Create test products before each test
    Product::create([
        'name' => 'Test Product 1',
        'description' => 'This is test product 1',
        'price' => 19.99,
        'stock' => 100,
        'is_active' => true
    ]);

    Product::create([
        'name' => 'Test Product 2',
        'description' => 'This is test product 2',
        'price' => 29.99,
        'stock' => 50,
        'is_active' => true
    ]);
});

/** * Test if the products can be listed successfully.
 *
 * This test checks if the API endpoint for listing products returns
 * a successful response with the expected structure and data.
 */
test('can list all products', function (): void
{
    // Make a GET request to the products endpoint
    $response = $this->getJson('/api/products');

    // Assert the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert the response contains the expected structure
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'description',
                'price',
                'stock',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ]
    ]);

    // Assert the response contains 2 products
    $response->assertJsonCount(2, 'data');
});

/** * Test if a single product can be retrieved successfully.
 *
 * This test checks if the API endpoint for retrieving a single product
 * returns a successful response with the expected structure and data.
 */
test('can get a single product', function (): void
{
    // Get the first product from the database
    $product = Product::first();

    // Make a GET request to the product endpoint
    $response = $this->getJson("/api/products/{$product->id}");

    // Assert the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert the response contains the expected structure
    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'description',
            'price',
            'stock',
            'is_active',
            'created_at',
            'updated_at'
        ]
    ]);

    // Assert the response contains the correct product data
    $response->assertJson([
        'data' => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'is_active' => $product->is_active
        ]
    ]);
});

/** * Test if a 404 error is returned for a non-existent product.
 *
 * This test checks if the API endpoint for retrieving a product
 * returns a 404 status code when the product does not exist.
 */
test('returns 404 for non-existent product', function (): void
{
    // Make a GET request to a non-existent product endpoint
    $response = $this->getJson('/api/products/999');

    // Assert the response status is 404 (Not Found)
    $response->assertStatus(404);

    // Assert the response contains an error message
    $response->assertJsonStructure([
        'message',
        'error'
    ]);
});

/** * Test if a product can be created successfully.
 *
 * This test checks if the API endpoint for creating a product
 * returns a successful response with the expected structure and data.
 */
test('can create a product', function (): void
{
    // Create product data
    $productData = [
        'name' => 'New Test Product',
        'description' => 'This is a new test product',
        'price' => 39.99,
        'stock' => 75,
        'is_active' => true
    ];

    // Make a POST request to create a product
    $response = $this->postJson('/api/products', $productData);

    // Assert the response status is 201 (Created)
    $response->assertStatus(201);

    // Assert the response contains the expected structure
    $response->assertJsonStructure([
        'message',
        'data' => [
            'id',
            'name',
            'description',
            'price',
            'stock',
            'is_active',
            'created_at',
            'updated_at'
        ]
    ]);

    // Assert the response contains the correct product data
    $response->assertJson([
        'message' => 'Product created successfully',
        'data' => [
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => (string) $productData['price'],
            'stock' => $productData['stock'],
            'is_active' => $productData['is_active']
        ]
    ]);

    // Assert the product was actually created in the database
    $this->assertDatabaseHas('products', [
        'name' => $productData['name'],
        'description' => $productData['description'],
        'price' => $productData['price'],
        'stock' => $productData['stock'],
        'is_active' => $productData['is_active']
    ]);
});

/** * Test if required fields are validated when creating a product.
 *
 * This test checks if the API endpoint for creating a product
 * returns a 422 status code when required fields are missing.
 */
test('validates required fields when creating a product', function (): void
{
    // Create product data with missing required fields
    $productData = [
        'description' => 'This product is missing required fields'
    ];

    // Make a POST request to create a product
    $response = $this->postJson('/api/products', $productData);

    // Assert the response status is 422 (Unprocessable Entity)
    $response->assertStatus(422);

    // Assert the response contains validation errors
    $response->assertJsonValidationErrors(['name', 'price', 'stock']);
});

/** * Test if a product can be updated successfully.
 *
 * This test checks if the API endpoint for updating a product
 * returns a successful response with the expected structure and data.
 */
test('can update a product', function (): void
{
    // Get the first product from the database
    $product = Product::first();

    // Create update data
    $updateData = [
        'name' => 'Updated Product Name',
        'price' => 49.99,
        'stock' => 60
    ];

    // Make a PUT request to update the product
    $response = $this->putJson("/api/products/{$product->id}", $updateData);

    // Assert the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert the response contains the expected structure
    $response->assertJsonStructure([
        'message',
        'data' => [
            'id',
            'name',
            'description',
            'price',
            'stock',
            'is_active',
            'created_at',
            'updated_at'
        ]
    ]);

    // Assert the response contains the correct updated product data
    $response->assertJson([
        'message' => 'Product updated successfully',
        'data' => [
            'id' => $product->id,
            'name' => $updateData['name'],
            'price' => (string) $updateData['price'],
            'stock' => $updateData['stock']
        ]
    ]);

    // Assert the product was actually updated in the database
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $updateData['name'],
        'price' => $updateData['price'],
        'stock' => $updateData['stock']
    ]);
});

/** * Test if required fields are validated when updating a product.
 *
 * This test checks if the API endpoint for updating a product
 * returns a 422 status code when required fields are missing.
 */
test('can delete a product', function (): void
{
    // Get the first product from the database
    $product = Product::first();

    // Make a DELETE request to delete the product
    $response = $this->deleteJson("/api/products/{$product->id}");

    // Assert the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert the response contains a success message
    $response->assertJson([
        'message' => 'Product deleted successfully'
    ]);

    // Assert the product was actually deleted from the database
    $this->assertDatabaseMissing('products', [
        'id' => $product->id
    ]);
});

/** * Test if a 404 error is returned when deleting a non-existent product.
 *
 * This test checks if the API endpoint for deleting a product
 * returns a 404 status code when the product does not exist.
 */
test('returns 404 when deleting non-existent product', function (): void
{
    // Make a DELETE request to a non-existent product endpoint
    $response = $this->deleteJson('/api/products/999');

    // Assert the response status is 404 (Not Found)
    $response->assertStatus(404);

    // Assert the response contains an error message
    $response->assertJsonStructure([
        'message',
        'error'
    ]);
});