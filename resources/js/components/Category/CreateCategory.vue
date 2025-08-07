<template>
  <AppLayout>
    <div class="form-wrapper">
      <h2>{{ isEditMode ? 'Edit Category' : 'Create New Category' }}</h2>

      <form @submit.prevent="submitCategory" class="post-form">
        <div class="form-group">
          <label for="name">Category Name</label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            required
            placeholder="Enter category name"
          />
        </div>

        <button type="submit" class="submit-btn">
          {{ isEditMode ? 'Update Category' : 'Create Category' }}
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import '../../../css/categoryForm.css'

const route = useRoute()
const router = useRouter()
const isEditMode = ref(false)

const form = ref({
  name: ''
})

const fetchCategory = async (id) => {
  try {
    const res = await axios.get(`/api/categories/get/${id}`)
    form.value.name = res.data.data.name
  } catch (err) {
    console.error('Error loading category:', err)
    alert('Failed to load category data')
  }
}

const submitCategory = async () => {
  try {
    if (isEditMode.value) {
      await axios.put(`/api/categories/update/${route.params.id}`, form.value)
      alert('Category updated successfully!')
    } else {
      await axios.post('/api/categories/save', form.value)
      alert('Category created successfully!')
    }
    router.push('/categories')
  } catch (error) {
    console.error('Submission error:', error)
    alert('Failed to save category')
  }
}

onMounted(() => {
  if (route.params.id) {
    isEditMode.value = true
    fetchCategory(route.params.id)
  }
})
</script>
