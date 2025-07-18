/* * Composable for managing products in the CMF Code Samples application.
   * This file provides functions to fetch, create, update, and delete products.
 */

import { ref } from 'vue';
import axios from 'axios';

// Define the Product interface to match the API response structure
export interface Product {
  id: number;
  name: string;
  description: string | null;
  price: number;
  stock: number;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

// Define the ProductForm interface for creating or updating products
export interface ProductForm {
  name: string;
  description: string | null;
  price: number;
  stock: number;
  is_active: boolean;
}

// Composable function to manage products
export default function useProducts() {
  const products = ref<Product[]>([]);
  const product = ref<Product | null>(null);
  const loading = ref(false);
  const error = ref<string | null>(null);

  // Fetch all products
  const fetchProducts = async () => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await axios.get('/api/products');
      // Ensure price is converted to a number for each product
      products.value = response.data.data.map((product: any) => ({
        ...product,
        price: typeof product.price === 'string' ? parseFloat(product.price) : product.price
      }));
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch products';
      console.error(error.value);
    } finally {
      loading.value = false;
    }
  };

  // Fetch a single product
  const fetchProduct = async (id: number) => {
    loading.value = true;
    error.value = null;
    product.value = null;
    
    try {
      const response = await axios.get(`/api/products/${id}`);
      // Ensure price is converted to a number
      const productData = response.data.data;
      product.value = {
        ...productData,
        price: typeof productData.price === 'string' ? parseFloat(productData.price) : productData.price
      };
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch product';
      console.error(error.value);
    } finally {
      loading.value = false;
    }
  };

  // Create a new product
  const createProduct = async (productData: ProductForm) => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await axios.post('/api/products', productData);
      return response.data.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to create product';
      console.error(error.value);
      throw err;
    } finally {
      loading.value = false;
    }
  };

  // Update a product
  const updateProduct = async (id: number, productData: ProductForm) => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await axios.put(`/api/products/${id}`, productData);
      return response.data.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to update product';
      console.error(error.value);
      throw err;
    } finally {
      loading.value = false;
    }
  };

  // Delete a product
  const deleteProduct = async (id: number) => {
    loading.value = true;
    error.value = null;
    
    try {
      await axios.delete(`/api/products/${id}`);
      return true;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to delete product';
      console.error(error.value);
      throw err;
    } finally {
      loading.value = false;
    }
  };

  // Return the reactive properties and methods
  return {
    products,
    product,
    loading,
    error,
    fetchProducts,
    fetchProduct,
    createProduct,
    updateProduct,
    deleteProduct
  };
}