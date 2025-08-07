<template>
  <AppLayout>
    <div class="page">
      <div class="container">
        <!-- Header -->
        <div class="header">
          <h2 class="heading">📁 Categories</h2>
          <div class="actions">
            <router-link to="/categories/create" class="btn btn-blue">+ Create Category</router-link>
          </div>
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
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="category in categories" :key="category.id">
                <td class="bold">{{ category.name }}</td>
                <td>{{ category.tenant?.name || category.tenant_id }}</td>
                <td>
                  <router-link :to="`/categories/edit/${category.id}`">
                    <button class="edit-btn">Edit</button>
                  </router-link>
                  <button class="delete-btn" @click="deleteCategory(category.id)">Delete</button>
                </td>
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
import '../../../css/categoryList.css'
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

const deleteCategory = async (id) => {
  if (!confirm('Are you sure you want to delete this category?')) return

  try {
    await axios.delete(`/api/categories/delete/${id}`)
    categories.value = categories.value.filter(cat => cat.id !== id)
    alert('Category deleted successfully!')
  } catch (error) {
    console.error('Failed to delete category:', error)
    alert('Failed to delete the category.')
  }
}

onMounted(() => {
  fetchCategories()
})
</script>
