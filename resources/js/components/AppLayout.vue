<template>
  <div class="layout-container">
    <header class="header">
      <div class="nav-links">
        <router-link to="/categories" class="nav-link">Categories</router-link>
        <router-link to="/" class="nav-link">Posts</router-link>
      </div>
      <button class="logout-btn" @click="logout">Logout</button>
    </header>

    <main class="content">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function logout() {
  localStorage.removeItem('access_token')
  router.push('/login')
}
</script>

<style scoped>
.layout-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ccc;
}

.nav-links {
  display: flex;
  gap: 1rem;
}

.nav-link {
  text-decoration: none;
  color: #333;
  font-weight: bold;
}

.nav-link:hover {
  text-decoration: underline;
  color: #007BFF;
}

.logout-btn {
  background-color: #e74c3c;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.logout-btn:hover {
  background-color: #c0392b;
}

.content {
  padding: 2rem;
}
</style>
