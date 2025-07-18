<script setup lang="ts">
// View Component for listing products

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import useProducts from '@/composables/useProducts';

// Get the product ID from the URL
const props = defineProps<{
  id: number;
}>();

const { product, loading, error, fetchProduct, deleteProduct } = useProducts();

// Fetch product when component is mounted
onMounted(() => {
  fetchProduct(props.id);
});

// Handle product deletion
const handleDelete = async () => {
  if (confirm('Are you sure you want to delete this product?')) {
    try {
      await deleteProduct(props.id);
      // Redirect to products list
      window.location.href = '/products';
    } catch (e) {
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
  {
    title: 'View Product',
    href: `/products/${props.id}`,
  },
];
</script>

<template>
  <Head title="View Product" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">View Product</h1>
        <div class="flex space-x-2">
          <Link 
            :href="`/products/${id}/edit`" 
            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
          >
            Edit
          </Link>
          <button 
            @click="handleDelete" 
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
          >
            Delete
          </button>
        </div>
      </div>

      <div v-if="loading" class="text-center py-4">
        Loading product...
      </div>

      <div v-else-if="error" class="text-center py-4 text-red-500">
        {{ error }}
      </div>

      <div v-else-if="!product" class="text-center py-4">
        Product not found.
      </div>

      <div v-else class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow max-w-2xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Product ID</h3>
            <p class="mt-1 text-lg font-semibold">{{ product.id }}</p>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
            <p class="mt-1">
              <span 
                :class="product.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                class="px-2 py-1 rounded-full text-xs"
              >
                {{ product.is_active ? 'Active' : 'Inactive' }}
              </span>
            </p>
          </div>

          <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</h3>
            <p class="mt-1 text-lg font-semibold">{{ product.name }}</p>
          </div>

          <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
            <p class="mt-1">{{ product.description || 'No description provided' }}</p>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h3>
            <p class="mt-1 text-lg font-semibold">${{ typeof product.price === 'number' ? product.price.toFixed(2) : parseFloat(product.price).toFixed(2) }}</p>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h3>
            <p class="mt-1 text-lg font-semibold">{{ product.stock }}</p>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</h3>
            <p class="mt-1">{{ new Date(product.created_at).toLocaleString() }}</p>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</h3>
            <p class="mt-1">{{ new Date(product.updated_at).toLocaleString() }}</p>
          </div>
        </div>

        <div class="mt-8 flex justify-center">
          <Link 
            href="/products" 
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
          >
            Back to Products
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>