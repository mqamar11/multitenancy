<!-- components/Layout.vue -->
<template>
  <div class="layout-container">
    <header class="header">
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
  localStorage.removeItem('token')
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
  justify-content: flex-end;
  padding: 1rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ccc;
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
