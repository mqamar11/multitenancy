<template>
    <AppLayout>
  <div class="form-wrapper">
    <h2>{{ isEditMode ? 'Edit Post' : 'Create New Post' }}</h2>
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

      <!-- <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" v-model="form.content" required></textarea>
      </div> -->

      <div class="form-group">
  <label for="content">Content</label>
  <QuillEditor
    v-model:content="form.content"
    contentType="html"
    theme="snow"
    style="min-height: 200px;"
  />
</div>


      <div class="form-group">
        <label for="image">Featured Image</label>
        <input id="image" type="file" @change="handleFileUpload" />
      </div>

      <button type="submit" class="submit-btn">{{ isEditMode ? 'Update Post' : 'Create Post' }}</button>
    </form>
  </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../AppLayout.vue'
import '../../../css/postCreate.css'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

import axios from 'axios'

const form = ref({
  title: '',
  content: '',
  category_id: '',
  featured_image: null,
})


const route = useRoute()
const isEditMode = ref(false)
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

const fetchPostData = async () => {
  try {
    const res = await axios.get(`/api/posts/get/${route.params.id}`)
    console.log('route', route.params.id)
    console.log('res', res )
    const data = res.data.data
    console.log(data)
    form.value.title = data.title
    form.value.content = data.content
    form.value.category_id = data.category_id
  } catch (err) {
    console.error('Failed to fetch post', err)
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
    if (isEditMode.value) {
      await axios.post(`/api/posts/update/${route.params.id}?_method=PUT`, payload)
      alert('Post updated successfully!')
    } else {
      await axios.post('/api/posts/save', payload)
      alert('Post created successfully!')
    }

    form.value = {
      title: '',
      content: '',
      category_id: '',
      featured_image: null,
    }
  } catch (err) {
    console.error('Error saving post:', err.response?.data)
    alert('Failed to save post')
  }
}

onMounted(async () => {
  await fetchCategories()
  if (route.params.id) {
    isEditMode.value = true
    await fetchPostData()
  }
})

</script>

