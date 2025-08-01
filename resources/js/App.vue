<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">CMS</h1>

    <nav class="mb-4">
      <button
        @click="goToCreatePost"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2"
      >
        Create Post
      </button>
      <button
        @click="goToHome"
        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
      >
        Home
      </button>
    </nav>

    <router-view /> <!-- 🔥 This renders PostList, PostCreate, etc. -->
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function goToCreatePost() {
  router.push('/post/create')
}

function goToHome() {
  router.push('/')
}
</script>
