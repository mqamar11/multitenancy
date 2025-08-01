import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue'
import PostList from './components/Post/PostList.vue'
import PostCreate from './components/Post/PostCreate.vue'
import PostView from './components/Post/PostView.vue'

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
