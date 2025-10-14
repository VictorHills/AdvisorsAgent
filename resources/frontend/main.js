import { createApp } from "vue"
import { createRouter, createWebHistory } from "vue-router"
import App from "./App.vue"
import "./app.css"

// Import pages
import Login from "./pages/Login.vue"
import Register from "./pages/Register.vue"
import Dashboard from "./pages/Dashboard.vue"
import CreateApplication from "./pages/CreateApplication.vue"

// Setup router
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: "/login",
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
            meta: { guest: true },
        },
        {
            path: "/register",
            name: "Register",
            component: Register,
            meta: { guest: true },
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
            meta: { requiresAuth: true },
        },
        {
            path: "/applications/create",
            name: "CreateApplication",
            component: CreateApplication,
            meta: { requiresAuth: true },
        },
    ],
})

// Navigation guard for authentication
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("auth_token")

    if (to.meta.requiresAuth && !token) {
        next("/login")
    } else if (to.meta.guest && token) {
        next("/dashboard")
    } else {
        next()
    }
})

const app = createApp(App)
app.use(router)
app.mount("#app")
