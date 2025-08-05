<template>
  <div class="p-4">
    <h2 class="text-xl mb-2">Login</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" class="block mb-2" />
      <input v-model="password" type="password" placeholder="Password" class="block mb-2" />
      <button type="submit" class="bg-blue-500 text-white px-4 py-2">Login</button>
    </form>
    <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        })

        const token = response.data.token
        localStorage.setItem('access_token', token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        this.$router.push('/') // redirect to home or protected route
      } catch (err) {
        this.error = 'Invalid credentials'
      }
    }
  }
}
</script>
