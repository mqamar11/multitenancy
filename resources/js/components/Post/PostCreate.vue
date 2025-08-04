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

<style scoped>
.form-wrapper {
  max-width: 600px;
  margin: 30px auto;
  padding: 25px;
  background-color: #f9f9f9;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 20px;
  text-align: center;
  font-size: 24px;
  color: #333;
}

.post-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  font-weight: 600;
  margin-bottom: 5px;
  color: #555;
}

input[type="text"],
textarea,
select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  transition: border 0.3s;
}

input[type="text"]:focus,
textarea:focus,
select:focus {
  border-color: #007bff;
  outline: none;
}

textarea {
  resize: vertical;
  min-height: 120px;
}

.submit-btn {
  background-color: #007bff;
  color: white;
  font-size: 16px;
  padding: 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

.submit-btn:hover {
  background-color: #0056b3;
}
</style>
