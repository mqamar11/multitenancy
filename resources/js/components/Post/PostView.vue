<template>
  <div v-if="post">
    <h2>{{ post.title }}</h2>
    <img v-if="post.featured_image" :src="post.featured_image" style="max-width: 100%; height: auto;">
    <div v-html="post.content"></div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const post = ref(null)
const route = useRoute()

onMounted(async () => {
  try {
    const response = await axios.get(`/api/posts/${route.params.id}`)
    post.value = response.data.data
  } catch (err) {
    console.error(err)
  }
})
</script>
