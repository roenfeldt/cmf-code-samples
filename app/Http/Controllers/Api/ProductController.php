<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the Product resource, which retrieves all products
     * from the database and returns them in a JSON response.
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        
        return response()->json([
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage, which validates the incoming
     * request data, attempts to create a new product in the database,
     * and returns a JSON response with the created product or an error message.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $product = Product::create($validated);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => $product
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed for product creation',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create product due to an error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource, which attempts to retrieve a product
     * by its ID and returns it in a JSON response, or an error message
     * if the product is not found.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            
            return response()->json([
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Product not found or failed to retrieve',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage, which validates the incoming
     * request data, attempts to update an existing product
     * in the database, and returns a JSON response
     * with the updated product or an error message.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'stock' => 'sometimes|required|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $product->update($validated);

            return response()->json([
                'message' => 'Product updated successfully',
                'data' => $product
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed for product update',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Product not found or failed to update product',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage, which attempts to delete a product
     * by its ID and returns a JSON response indicating success or failure.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            
            return response()->json([
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Product not found or failed to delete product',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
