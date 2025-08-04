import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue' // ✅ This was missing!
import PostList from './components/PostList.vue'
import PostView from './components/PostView.vue'
import PostCreate from './components/PostCreate.vue'

const routes = [
    { path: '/', component: PostList },
     { path: '/post/create', component: PostCreate },
    { path: '/posts/:id', component: PostView },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp(App)
app.use(router)
app.mount('#app')
