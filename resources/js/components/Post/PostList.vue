<template>
  <div>
    <h2 class="text-xl font-semibold mb-2">Posts</h2>
    <div v-if="loading">Loading...</div>
    <div v-else-if="posts.length === 0">No posts found.</div>
    <ul v-else>
      <li v-for="post in posts" :key="post.id" class="mb-2">
        <strong>{{ post.title }}</strong> - {{ post.category?.name || 'No Category' }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const posts = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('/api/posts')
    posts.value = response.data.data
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
})
</script>
