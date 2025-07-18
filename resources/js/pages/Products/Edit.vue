<script setup lang="ts">
// View Component for editing an existing product

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import useProducts, { type ProductForm } from '@/composables/useProducts';

// Get the product ID from the URL
const props = defineProps<{
  id: number;
}>();

const { product, loading, error, fetchProduct, updateProduct } = useProducts();

// Initialize form data
const form = ref<ProductForm>({
  name: '',
  description: '',
  price: 0,
  stock: 0,
  is_active: true
});

// Form validation errors
const validationErrors = ref<Record<string, string[]>>({});

// Fetch product when component is mounted
onMounted(async () => {
  await fetchProduct(props.id);
  
  // Populate form with product data when available
  if (product.value) {
    form.value = {
      name: product.value.name,
      description: product.value.description,
      price: product.value.price,
      stock: product.value.stock,
      is_active: product.value.is_active
    };
  }
});

// Handle form submission
const handleSubmit = async () => {
  validationErrors.value = {};
  
  try {
    await updateProduct(props.id, form.value);
    // Redirect to product details on success
    router.visit(`/products/${props.id}`);
  } catch (error: any) {
    // Handle validation errors
    if (error.response?.status === 422) {
      validationErrors.value = error.response.data.errors;
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
    title: 'Edit Product',
    href: `/products/${props.id}/edit`,
  },
];
</script>

<template>
  <Head title="Edit Product" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Edit Product</h1>
      </div>

      <div v-if="loading && !product" class="text-center py-4">
        Loading product...
      </div>

      <div v-else-if="error && !product" class="text-center py-4 text-red-500">
        {{ error }}
      </div>

      <form v-else @submit.prevent="handleSubmit" class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <!-- Name field -->
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required
          />
          <div v-if="validationErrors.name" class="text-red-500 text-sm mt-1">
            {{ validationErrors.name[0] }}
          </div>
        </div>

        <!-- Description field -->
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
          ></textarea>
          <div v-if="validationErrors.description" class="text-red-500 text-sm mt-1">
            {{ validationErrors.description[0] }}
          </div>
        </div>

        <!-- Price field -->
        <div class="mb-4">
          <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price</label>
          <input
            id="price"
            v-model.number="form.price"
            type="number"
            step="0.01"
            min="0"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required
          />
          <div v-if="validationErrors.price" class="text-red-500 text-sm mt-1">
            {{ validationErrors.price[0] }}
          </div>
        </div>

        <!-- Stock field -->
        <div class="mb-4">
          <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
          <input
            id="stock"
            v-model.number="form.stock"
            type="number"
            min="0"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required
          />
          <div v-if="validationErrors.stock" class="text-red-500 text-sm mt-1">
            {{ validationErrors.stock[0] }}
          </div>
        </div>

        <!-- Active status field -->
        <div class="mb-6">
          <div class="flex items-center">
            <input
              id="is_active"
              v-model="form.is_active"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            />
            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
              Active
            </label>
          </div>
          <div v-if="validationErrors.is_active" class="text-red-500 text-sm mt-1">
            {{ validationErrors.is_active[0] }}
          </div>
        </div>

        <!-- Error message -->
        <div v-if="error" class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          {{ error }}
        </div>

        <!-- Form buttons -->
        <div class="flex justify-end space-x-3">
          <a
            :href="`/products/${id}`"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
          >
            Cancel
          </a>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
            :disabled="loading"
          >
            <span v-if="loading">Updating...</span>
            <span v-else>Update Product</span>
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>