import {createRouter, createWebHistory} from "vue-router"
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue"
import Dashboard from "../pages/Dashboard.vue"
import CreateApplication from "../pages/CreateApplication.vue"
import Students from "../pages/Students.vue"
import ForgotPassword from "../pages/ForgotPassword.vue"
import CreateStudent from "../pages/CreateStudent.vue"
import Applications from "../pages/Applications.vue";
import ViewApplication from "../pages/ViewApplication.vue";
import EditApplication from "../pages/EditApplication.vue";

const routes = [
    {path: "/", redirect: "/login"},
    {path: "/login", component: Login, name: "login"},
    {path: "/register", component: Register, name: "register"},
    {path: "/forgot-password", component: ForgotPassword, name: "forgot-password"},
    {path: "/applications", component: Applications, name: "applications", meta: {requiresAuth: true}},
    {path: '/applications/:id', name: 'ViewApplication', component: ViewApplication, meta: {requiresAuth: true}},
    {
        path: '/applications/:id/edit',
        name: 'EditApplication',
        component: EditApplication,
        meta: {
            requiresAuth: true,
            roles: ["counselor"]
        }
    },
    {
        path: "/dashboard",
        component: Dashboard,
        name: "dashboard",
        meta: {
            requiresAuth: true,
            roles: ["agent", "counselor"],
        },
    },
    {
        path: "/students/create",
        component: CreateStudent,
        name: "create-student",
        meta: {
            requiresAuth: true,
            roles: ["agent"],
        },
    },
    {
        path: "/students",
        component: Students,
        name: "students",
        meta: {
            requiresAuth: true,
            roles: ["agent", "counselor"],
        },
    },
    {
        path: "/applications/create",
        component: CreateApplication,
        name: "create-application",
        meta: {
            requiresAuth: true,
            roles: ["agent"],
        },
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("auth_token")
    const userStr = localStorage.getItem("user")

    const isAuthenticated = !!(token && userStr)
    let userRole = null

    if (isAuthenticated && userStr) {
        try {
            const user = JSON.parse(userStr)
            userRole = user.role_name?.toLowerCase() || user.role?.toLowerCase()
        } catch (e) {
            console.error("Error parsing user role:", e)
        }
    }

    if (to.meta.requiresAuth) {
        if (!isAuthenticated) {
            next("/login")
        } else if (to.meta.roles && !to.meta.roles.includes(userRole)) {
            // User doesn't have permission for this route
            next("/dashboard")
        } else {
            next()
        }
    } else if ((to.path === "/login" || to.path === "/register" || to.path === "/forgot-password") && isAuthenticated) {
        next("/dashboard")
    } else {
        next()
    }
})

export default router
