<template>
  <div class="min-h-screen bg-gray-100 py-16 px-4">
    <div class="w-full max-w-6xl mx-auto p-6 bg-white rounded-2xl shadow-lg">
      <!-- Header -->
      <div class="flex justify-between items-center border-b pb-4 mb-4">
        <h2 class="text-3xl font-bold text-gray-800">📚 Posts</h2>
        <router-link
          to="/post/create"
          class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 transition"
        >
          + Create Post
        </router-link>
      </div>

      <!-- Loading / Empty State -->
      <div v-if="loading" class="text-gray-500 text-center py-8">Loading...</div>
      <div v-else-if="posts.length === 0" class="text-gray-500 text-center py-8">No posts found.</div>

      <!-- Posts Table -->
      <div v-else class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-300 border-collapse table-auto">
          <thead class="bg-gray-200 text-xs uppercase text-gray-600">
            <tr>
              <th class="px-4 py-3 border border-gray-300">Image</th>
              <th class="px-4 py-3 border border-gray-300">Title</th>
              <th class="px-4 py-3 border border-gray-300">Category</th>
              <th class="px-4 py-3 border border-gray-300">Content</th>
              <th class="px-4 py-3 border border-gray-300">Created By</th>
              <th class="px-4 py-3 border border-gray-300">Updated By</th>
              <th class="px-4 py-3 border border-gray-300">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="post in posts"
              :key="post.id"
              class="bg-white hover:bg-gray-50"
            >
              <td class="px-4 py-2 border border-gray-300">
                <img
                  v-if="post.featured_image"
                  :src="post.featured_image"
                  alt="Featured"
                  class="w-16 h-16 object-cover rounded"
                />
                <span v-else class="text-gray-400 italic">No Image</span>
              </td>
              <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">
                {{ post.title }}
              </td>
              <td class="px-4 py-2 border border-gray-300">
                {{ post.category?.name || 'Uncategorized' }}
              </td>
              <td class="px-4 py-2 border border-gray-300 max-w-xs truncate" :title="post.content">
                {{ post.content }}
              </td>
              <td class="px-4 py-2 border border-gray-300">
                {{ post.creator?.name || 'N/A' }}
              </td>
              <td class="px-4 py-2 border border-gray-300">
                {{ post.editor?.name || 'N/A' }}
              </td>
              <td class="px-4 py-2 border border-gray-300">
                <router-link
                  :to="`/posts/${post.id}`"
                  class="text-blue-600 hover:underline"
                >
                  View
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
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

<style scoped>
.truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
