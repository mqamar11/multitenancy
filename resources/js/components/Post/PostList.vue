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
            <td class="rich-snippet" :title="post.content" v-html="post.content"></td>
              <td>{{ post.creator?.name || 'N/A' }}</td>
              <td>{{ post.editor?.name || 'N/A' }}</td>
              <td>
                 <router-link :to="`/posts/${post.id}/edit`">
                    <button class="edit-btn">Edit</button>
                 </router-link>
                 <button class="delete-btn" @click="deletePost(post.id)">Delete</button>
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
import axios from 'axios'

const posts = ref([])
const loading = ref(true)

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

const deletePost = async (id) => {
  if (!confirm('Are you sure you want to delete this post?')) return;

  try {
    await axios.delete(`/api/posts/delete/${id}`)
    posts.value = posts.value.filter(post => post.id !== id)
    alert('Post deleted successfully!')
  } catch (error) {
    console.error('Failed to delete post:', error)
    alert('Failed to delete the post.')
  }
}



onMounted(() => {
  fetchPosts()
})
</script>

