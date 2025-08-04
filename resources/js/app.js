import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'

import App from './App.vue'
import PostList from './components/Post/PostList.vue'
import PostView from './components/Post/PostView.vue'
import PostCreate from './components/Post/PostCreate.vue'

axios.defaults.withCredentials = true

const routes = [
    { path: '/', component: PostList },
    { path: '/post/create', component: PostCreate, meta: { requiresAuth: true } },
    { path: '/posts/:id', component: PostView },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        try {
            const response = await axios.get('/api/user')
            if (response.data) {
                next()
            } else {
                next('/')
            }
        } catch (error) {
            next('/')
        }
    } else {
        next()
    }
})

const app = createApp(App)
app.use(router)
app.mount('#app')
