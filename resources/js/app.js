import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import PostList from './components/PostList.vue'
import PostView from './components/PostView.vue'

const routes = [
    { path: '/', component: PostList },
    { path: '/posts/:id', component: PostView },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp({})
app.use(router)
app.mount('#app')
