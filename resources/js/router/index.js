import {createRouter, createWebHistory} from "vue-router"
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue"
import Dashboard from "../pages/Dashboard.vue"
import CreateApplication from "../pages/CreateApplication.vue"
import Team from "../pages/Team.vue"
import StudentApplication from "../pages/StudentApplication.vue"
import ForgotPassword from "../pages/ForgotPassword.vue"
import CreateStudent from "../pages/CreateStudent.vue";

const routes = [
    {path: "/", redirect: "/login"},
    {path: "/login", component: Login, name: "login"},
    {path: "/register", component: Register, name: "register"},
    {path: "/forgot-password", component: ForgotPassword, name: "forgot-password"},
    {path: "/dashboard", component: Dashboard, name: "dashboard", meta: {requiresAuth: true}},
    {path: "/create-student", component: CreateStudent, name: "create-student", meta: {requiresAuth: true}},
    {
        path: "/student-application",
        component: StudentApplication,
        name: "student-application",
        meta: {requiresAuth: true}
    },
    {
        path: "/applications/create",
        component: CreateApplication,
        name: "create-application",
        meta: {requiresAuth: true},
    },
    {path: "/team", component: Team, name: "team", meta: {requiresAuth: true}},
]

const router = createRouter({
    history: createWebHistory(), routes,
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("auth_token")
    const userStr = localStorage.getItem("user")

    const isAuthenticated = !!(token && userStr)

    if (to.meta.requiresAuth && !isAuthenticated) {
        next("/login")
    } else if ((to.path === "/login" || to.path === "/register" || to.path === '/forgot-password') && isAuthenticated) {
        next("/dashboard")
    } else {
        next()
    }
})

export default router
