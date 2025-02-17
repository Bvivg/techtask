import { createWebHistory, createRouter } from 'vue-router'
import Dashboard from './pages/Dashboard.vue'
import Auth from './pages/Auth.vue'


const routes = [
  { path: '/', component: Dashboard },
  { path: '/auth', component: Auth },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})
export default router