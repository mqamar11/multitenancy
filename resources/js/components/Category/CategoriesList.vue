<template>
  <AppLayout>
    <div class="page">
      <div class="container">
        <!-- Header -->
        <div class="header">
          <h2 class="heading">📁 Categories</h2>
          <!-- You can add a "Create Category" button later if needed -->
        </div>

        <!-- Loading / Empty State -->
        <div v-if="loading" class="status">Loading...</div>
        <div v-else-if="categories.length === 0" class="status">No categories found.</div>

        <!-- Categories Table -->
        <div v-else class="table-wrapper">
          <table class="category-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Tenant</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="category in categories" :key="category.id">
                <td class="bold">{{ category.name }}</td>
                <td>{{ category.tenant?.name || category.tenant_id }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import '../../../css/categoryList.css' // Reuse styles for layout/table
import { ref, onMounted } from 'vue'
import axios from 'axios'

const categories = ref([])
const loading = ref(true)

const fetchCategories = async () => {
  try {
    const res = await axios.get('/api/categories/list')
    categories.value = res.data.data
  } catch (err) {
    console.error('Error fetching categories:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCategories()
})
</script>
