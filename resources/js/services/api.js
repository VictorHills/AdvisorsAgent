import axios from "axios"

const api = axios.create({
    baseURL: "/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
})

api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("auth_token")
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    (error) => {
        return Promise.reject(error)
    },
)

api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem("auth_token")
            localStorage.removeItem("user")
            window.location.href = "/login"
        }
        return Promise.reject(error)
    },
)

export const authAPI = {
    login: (credentials) => api.post("/auth/login", credentials),
    register: (userData) => api.post("/auth/register", userData),
    logout: () => api.post("/auth/logout"),
    getUser: () => api.get("/user"),
}

export const dashboardAPI = {
    getStats: () => api.get("/dashboard/stats"),
    getApplicationsTrend: () => api.get("/dashboard/applications-trend"),
    getApplicationsStatus: () => api.get("/dashboard/applications-status"),
    getMonthlyApplications: () => api.get("/dashboard/monthly-applications"),
}

export const applicationsAPI = {
    getAll: () => api.get("/applications"),
    getOne: (id) => api.get(`/applications/${id}`),
    create: (data) => api.post("/applications", data),
    update: (id, data) => api.put(`/applications/${id}`, data),
    delete: (id) => api.delete(`/applications/${id}`),
}

export const studentsAPI = {
    getAll: () => api.get("/students"),
    getOne: (id) => api.get(`/students/${id}`),
}

export const bdmOfficersAPI = {
    getAll: () => api.get("/bdm-officers"),
    getOne: (id) => api.get(`/bdm-officers/${id}`),
}

export const coursesAPI = {
    getAll: () => api.get("/courses"),
    getOne: (id) => api.get(`/courses/${id}`),
}

export const schoolsAPI = {
    getAll: () => api.get("/schools"),
    getOne: (id) => api.get(`/schools/${id}`),
}

export default api
