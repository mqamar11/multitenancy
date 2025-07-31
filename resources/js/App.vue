<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">CMS</h1>

    <!-- <h2 class="text-xl font-semibold mb-2">Create New Post</h2> -->
    <PostCreate />

    <hr class="my-6" />

    <PostList />
  </div>
</template>

<script setup>
import PostList from './components/PostList.vue'
import PostCreate from './components/PostCreate.vue'
</script>
