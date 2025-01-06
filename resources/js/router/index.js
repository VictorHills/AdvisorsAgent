import {createRouter, createWebHistory} from "vue-router";

const Login = () => import("../pages/Login.vue");
const Register = () => import("../pages/Register.vue");
const Dashboard = () => import("../pages/Dashboard.vue");
const CreateApplication = () => import("../pages/CreateApplication.vue");
const Students = () => import("../pages/Students.vue");
const ForgotPassword = () => import("../pages/ForgotPassword.vue");
const CreateStudent = () => import("../pages/CreateStudent.vue");
const Applications = () => import("../pages/Applications.vue");
const ViewApplication = () => import("../pages/ViewApplication.vue");
const EditApplication = () => import("../pages/EditApplication.vue");
const Unauthorized = () => import("../pages/Unauthorized.vue");
const NotFound = () => import("../pages/NotFound.vue");
const Agents = () => import("../pages/Agents.vue");

const routes = [
    {path: "/", redirect: "/login"},
    {path: "/login", component: Login, name: "login"},
    {path: "/register", component: Register, name: "register"},
    {path: "/forgot-password", component: ForgotPassword, name: "forgot-password"},
    {
        path: "/dashboard",
        component: Dashboard,
        name: "dashboard",
        meta: {requiresAuth: true, roles: ["agent", "counselor"]},
    },
    {
        path: "/applications",
        component: Applications,
        name: "applications",
        meta: {requiresAuth: true, roles: ["agent", "counselor"]}
    },
    {
        path: "/applications/:id",
        name: "ViewApplication",
        component: ViewApplication,
        meta: {requiresAuth: true, roles: ["agent", "counselor"]}
    },
    {
        path: "/applications/:id/edit",
        name: "EditApplication",
        component: EditApplication,
        meta: {requiresAuth: true, roles: ["agent", "counselor"]}
    },
    {
        path: "/applications/create",
        component: CreateApplication,
        name: "create-application",
        meta: {requiresAuth: true, roles: ["agent"]},
    },
    {
        path: "/students",
        component: Students,
        name: "students",
        meta: {requiresAuth: true, roles: ["agent", "counselor"]},
    },
    {
        path: "/agents",
        component: Agents,
        name: "agents",
        meta: {requiresAuth: true, roles: ["counselor"]},
    },
    {
        path: "/students/create",
        component: CreateStudent,
        name: "create-student",
        meta: {requiresAuth: true, roles: ["agent"]},
    },
    {path: "/unauthorized", name: "Unauthorized", component: Unauthorized, meta: {requiresAuth: false}},
    {path: "/:pathMatch(.*)*", name: "NotFound", component: NotFound, meta: {requiresAuth: false}}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("auth_token");
    const userStr = localStorage.getItem("user");

    const isAuthenticated = !!(token && userStr);
    let userRole = null;

    if (isAuthenticated && userStr) {
        try {
            const user = JSON.parse(userStr);
            userRole = user.role_name?.toLowerCase() || user.role?.toLowerCase();
        } catch (e) {
            console.error("Error parsing user role:", e);
        }
    }

    if (to.meta.requiresAuth) {
        if (!isAuthenticated) {
            next("/login");
        } else if (to.meta.roles && !to.meta.roles.includes(userRole)) {
            next("/unauthorized");
        } else {
            next();
        }
    } else if (["/login", "/register", "/forgot-password"].includes(to.path) && isAuthenticated) {
        next("/dashboard");
    } else {
        next();
    }
});

export default router;
