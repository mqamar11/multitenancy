<template>
  <div>
    <h2>Create New Post</h2>
    <form @submit.prevent="submitPost" enctype="multipart/form-data">
      <div>
        <label>Category</label>
        <select v-model="form.category_id" required>
          <option v-for="category in categories" :value="category.id" :key="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div>
        <label>Title</label>
        <input type="text" v-model="form.title" required />
      </div>

      <div>
        <label>Content</label>
        <textarea v-model="form.content" required></textarea>
      </div>

      <div>
        <label>Featured Image</label>
        <input type="file" @change="handleFileUpload" />
      </div>

      <button type="submit">Create Post</button>
    </form>
  </div>
</template>

<script setup>
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
    const res = await axios.get('/api/categories')
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
    const res = await axios.post('/api/posts', payload)
    alert('Post created successfully!')
    // Optionally reset the form
  } catch (err) {
    console.error('Error creating post:', err.response?.data)
    alert('Failed to create post')
  }
}

onMounted(fetchCategories)
</script>
