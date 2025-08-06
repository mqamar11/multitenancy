<template>
  <div class="login-page">
    <div class="login-card">
      <h2 class="title">Welcome Back</h2>

      <form @submit.prevent="login" class="form">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="email"
            type="email"
            placeholder="Enter your email"
            class="form-input"
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password"
            v-model="password"
            type="password"
            placeholder="Enter your password"
            class="form-input"
          />
        </div>

        <button type="submit" class="login-button">Login</button>

        <p v-if="error" class="error-text">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import '../../../css/login.css'
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

        const token = response.data.access_token
        localStorage.setItem('access_token', token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        this.$router.push('/')
      } catch (err) {
        this.error = 'Invalid credentials'
      }
    }
  }
}
</script>
