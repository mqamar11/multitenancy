<template>
    <AppLayout>
  <div class="page">
    <div class="container">
      <!-- Header -->
      <div class="header">
        <h2 class="heading">📚 Posts</h2>
        <div class="actions">
          <router-link to="/post/create" class="btn btn-blue">+ Create Post</router-link>
          <!-- <button @click="logout" class="btn btn-red">Logout</button> -->
        </div>
      </div>

      <!-- Loading / Empty State -->
      <div v-if="loading" class="status">Loading...</div>
      <div v-else-if="posts.length === 0" class="status">No posts found.</div>

      <!-- Posts Table -->
      <div v-else class="table-wrapper">
        <table class="post-table">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Content</th>
              <th>Created By</th>
              <th>Updated By</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id">
              <td>
                <img
                  v-if="post.featured_image"
                  :src="post.featured_image"
                  alt="Featured"
                  class="thumbnail"
                />
                <span v-else class="no-image">No Image</span>
              </td>
              <td class="bold">{{ post.title }}</td>
              <td>{{ post.category?.name || 'Uncategorized' }}</td>
              <td class="truncate" :title="post.content">{{ post.content }}</td>
              <td>{{ post.creator?.name || 'N/A' }}</td>
              <td>{{ post.editor?.name || 'N/A' }}</td>
              <td>
                <router-link :to="`/posts/${post.id}`" class="link">View</router-link>
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
import '../../../css/postList.css'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const posts = ref([])
const loading = ref(true)
const router = useRouter()

const fetchPosts = async () => {
  try {
    const response = await axios.get('/api/posts/list')
    posts.value = response.data.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

const logout = async () => {
  try {
    await axios.post('/api/logout')
    localStorage.removeItem('access_token')
    delete axios.defaults.headers.common['Authorization']
    router.push('/login')
  } catch (error) {
    console.error('Logout failed', error)
  }
}

onMounted(() => {
  fetchPosts()
})
</script>

