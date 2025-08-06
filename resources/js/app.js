import './bootstrap'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'

import App from './App.vue'
import PostList from './components/Post/PostList.vue'
import PostView from './components/Post/PostView.vue'
import PostCreate from './components/Post/PostCreate.vue'
import Login from './components/auth/Login.vue'

// 💡 Use token-based header
const token = localStorage.getItem('access_token')
console.log(token);
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

const routes = [
    { path: '/', component: PostList, meta: { requiresAuth: true } },
    { path: '/post/create', component: PostCreate, meta: { requiresAuth: true } },
    { path: '/posts/:id', component: PostView },
    { path: '/login', component: Login },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// router.beforeEach(async (to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         try {
//             const response = await axios.get('/api/user')
//             if (response.data) {
//                 next()
//             } else {
//                 next('/login')
//             }
//         } catch (error) {
//             next('/login')
//         }
//     } else {
//         next()
//     }
// })

const app = createApp(App)
app.use(router)
app.mount('#app')
