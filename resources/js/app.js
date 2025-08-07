import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'


import App from './App.vue'
import Login from './components/auth/Login.vue'
import CategoriesList from './components/Category/CategoriesList.vue'
import CategoryForm from './components/Category/CreateCategory.vue'
import PostList from './components/Post/PostList.vue'
import PostView from './components/Post/PostView.vue'
import PostCreate from './components/Post/PostCreate.vue'


// Use token-based header
const token = localStorage.getItem('access_token')
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

const routes = [
    { path: '/login', component: Login },

    { path: '/categories', component: CategoriesList, meta: { requiresAuth: true } },
    { path: '/categories/create', component: CategoryForm, meta: { requiresAuth: true } },
    { path: '/categories/edit/:id', component: CategoryForm, meta: { requiresAuth: true } },

    { path: '/', component: PostList, meta: { requiresAuth: true } },
    { path: '/post/create', component: PostCreate, meta: { requiresAuth: true } },
    { path: '/posts/:id/edit', component: PostCreate, meta: { requiresAuth: true } },
    { path: '/posts/:id', component: PostView },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('access_token')

    // If route requires auth and no token exists, redirect to login
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) {
            return next('/login')
        }

        try {
            await axios.get('/api/user') // token will be sent in headers
            next() // token valid
        } catch (error) {
            // Token invalid or expired
            localStorage.removeItem('access_token')
            next('/login')
        }
    } else {
        next() // No auth required
    }
})

const app = createApp(App)
app.use(router)
app.mount('#app')
