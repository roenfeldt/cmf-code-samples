<script setup lang="ts">
// View Component for listing products

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import useProducts from '@/composables/useProducts';

const { products, loading, error, fetchProducts, deleteProduct } = useProducts();

// Fetch products when component is mounted
onMounted(() => {
  fetchProducts();
});

// Handle product deletion
const handleDelete = async (id: number) => {
  if (confirm('Are you sure you want to delete this product?')) {
    try {
      await deleteProduct(id);
      // Refresh the products list
      fetchProducts();
    } catch (err) {
      // Error is already handled in the composable
    }
  }
};

// Breadcrumbs for navigation
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
  {
    title: 'Products',
    href: '/products',
  },
];
</script>

<template>
  <Head title="Products" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Products</h1>
        <Link 
          href="/products/create" 
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
        >
          Create Product
        </Link>
      </div>

      <div v-if="loading" class="text-center py-4">
        Loading products...
      </div>

      <div v-else-if="error" class="text-center py-4 text-red-500">
        {{ error }}
      </div>

      <div v-else-if="products.length === 0" class="text-center py-4">
        No products found. Create your first product!
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">ID</th>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Name</th>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Price</th>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Stock</th>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Status</th>
              <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ product.id }}</td>
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ product.name }}</td>
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">${{ typeof product.price === 'number' ? product.price.toFixed(2) : parseFloat(product.price).toFixed(2) }}</td>
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ product.stock }}</td>
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                <span 
                  :class="product.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                  class="px-2 py-1 rounded-full text-xs"
                >
                  {{ product.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex space-x-2">
                  <Link 
                    :href="`/products/${product.id}`" 
                    class="text-blue-500 hover:text-blue-700"
                  >
                    View
                  </Link>
                  <Link 
                    :href="`/products/${product.id}/edit`" 
                    class="text-yellow-500 hover:text-yellow-700"
                  >
                    Edit
                  </Link>
                  <button 
                    @click="handleDelete(product.id)" 
                    class="text-red-500 hover:text-red-700"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>