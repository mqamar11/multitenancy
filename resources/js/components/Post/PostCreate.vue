<template>
    <AppLayout>
  <div class="form-wrapper">
    <h2>Create New Post</h2>
    <form @submit.prevent="submitPost" enctype="multipart/form-data" class="post-form">
      <div class="form-group">
        <label for="category">Category</label>
        <select v-model="form.category_id" id="category" required>
          <option v-for="category in categories" :value="category.id" :key="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="title">Title</label>
        <input id="title" type="text" v-model="form.title" required />
      </div>

      <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" v-model="form.content" required></textarea>
      </div>

      <div class="form-group">
        <label for="image">Featured Image</label>
        <input id="image" type="file" @change="handleFileUpload" />
      </div>

      <button type="submit" class="submit-btn">Create Post</button>
    </form>
  </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import '../../../css/postCreate.css'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const form = ref({
  title: '',
  content: '',
  category_id: '',
  featured_image: null,
})

const categories = ref([])

const handleFileUpload = (e) => {
  form.value.featured_image = e.target.files[0]
}

const fetchCategories = async () => {
  try {
    const res = await axios.get('/api/categories/list')
    categories.value = res.data.data
  } catch (error) {
    console.error('Failed to load categories', error)
  }
}

const submitPost = async () => {
  const payload = new FormData()
  payload.append('title', form.value.title)
  payload.append('content', form.value.content)
  payload.append('category_id', form.value.category_id)
  if (form.value.featured_image) {
    payload.append('featured_image', form.value.featured_image)
  }

  try {
    await axios.post('/api/posts', payload)
    alert('Post created successfully!')
    // Reset form (optional)
    form.value = {
      title: '',
      content: '',
      category_id: '',
      featured_image: null,
    }
  } catch (err) {
    console.error('Error creating post:', err.response?.data)
    alert('Failed to create post')
  }
}

onMounted(fetchCategories)
</script>

