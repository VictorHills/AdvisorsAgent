import { createRouter, createWebHistory } from "vue-router"
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue"
import Dashboard from "../pages/Dashboard.vue"
import CreateApplication from "../pages/CreateApplication.vue"
import Team from "../pages/Team.vue"
import Students from "../pages/Students.vue"

const routes = [
    { path: "/", redirect: "/login" },
    { path: "/login", component: Login, name: "login" },
    { path: "/register", component: Register, name: "register" },
    { path: "/dashboard", component: Dashboard, name: "dashboard" },
    { path: "/students", component: Students, name: "students" },
    { path: "/applications/create", component: CreateApplication, name: "create-application" },
    { path: "/team", component: Team, name: "team" },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
