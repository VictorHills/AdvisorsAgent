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
    getOtp: (data) => api.post("/auth/otp", data),
    resetPassword: (data) => api.post("/auth/reset-password", data),
    verifyOtp: (email, token, destination) => api.post("/auth/verify-otp", {email, token, destination}),
}

export const dashboardAPI = {
    getStats: () => api.get("/dashboard/stats"),
    getApplicationsTrend: () => api.get("/dashboard/applications-trend"),
    getApplicationsStatus: () => api.get("/dashboard/applications-status"),
    getMonthlyApplications: () => api.get("/dashboard/monthly-applications"),
    getRecentActivity: () => api.get("/dashboard/recent-activity"),
}

export const applicationsAPI = {
    getAll: () => api.get("/applications"),
    getOne: (id) => api.get(`/applications/${id}`),
    getByStudentId: (studentId) => api.get(`/students/${studentId}`),
    create: (data) => {
        const formData = new FormData()

        // Add all form fields except files
        Object.keys(data).forEach((key) => {
            if (key !== "application_documents") {
                if (Array.isArray(data[key])) {
                    data[key].forEach((item, index) => {
                        formData.append(`${key}[${index}]`, item)
                    })
                } else {
                    formData.append(key, data[key])
                }
            }
        })

        // Add files with proper array syntax for Laravel
        if (data.application_documents && data.application_documents.length > 0) {
            data.application_documents.forEach((file, index) => {
                formData.append(`application_documents[${index}]`, file)
            })
        }

        return api.post("/applications", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
    },
    update: (id, data) => {
        const formData = new FormData()

        Object.keys(data).forEach((key) => {
            if (key !== "application_documents") {
                if (Array.isArray(data[key])) {
                    data[key].forEach((item, index) => {
                        formData.append(`${key}[${index}]`, item)
                    })
                } else {
                    formData.append(key, data[key])
                }
            }
        })

        if (data.application_documents && data.application_documents.length > 0) {
            data.application_documents.forEach((file, index) => {
                formData.append(`application_documents[${index}]`, file)
            })
        }

        return api.put(`/applications/${id}`, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
    },
    patch: (id, data) => {
        const formData = new FormData()

        Object.keys(data).forEach((key) => {
            if (key !== "application_documents") {
                if (Array.isArray(data[key])) {
                    data[key].forEach((item, index) => {
                        formData.append(`${key}[${index}]`, item)
                    })
                } else {
                    formData.append(key, data[key])
                }
            }
        })

        if (data.application_documents && data.application_documents.length > 0) {
            data.application_documents.forEach((file, index) => {
                formData.append(`application_documents[${index}]`, file)
            })
        }

        return api.patch(`/applications/${id}`, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
    },
    delete: (id) => api.delete(`/applications/${id}`),
}

export const studentsAPI = {
    getAll: (page = 1, perPage = 10) => api.get("/students", {params: {page, per_page: perPage}}),
    getOne: (id) => api.get(`/students/${id}`),
    validateStudent: (email) => api.post("/students/validate", {email}),
    create: (data) => api.post("/students", data),
}

export const bdmOfficersAPI = {
    getAll: () => api.get("/bdm-officers"),
    getOne: (id) => api.get(`/bdm-officers/${id}`),
}

export const coursesAPI = {
    getAll: () => api.get("/courses"),
    search: (searchTerm = "", perPage = 10) => api.get("/courses", {params: {search: searchTerm, per_page: perPage}}),
    getOne: (id) => api.get(`/courses/${id}`),
}

export const schoolsAPI = {
    getAll: () => api.get("/schools"),
    search: (searchTerm = "", perPage = 10) => api.get("/schools", {params: {search: searchTerm, per_page: perPage}}),
    getOne: (id) => api.get(`/schools/${id}`),
}

export const countriesAPI = {
    getAll: () => api.get("/countries"),
    search: (searchTerm = "", perPage = 10) =>
        api.get("/countries", {params: {search: searchTerm, per_page: perPage}}),
    getOne: (id) => api.get(`/countries/${id}`),
}

export const adminDashboardAPI = {
    getStats: () => api.get("/admin/dashboard/stats"),
    getApplicationsTrend: () => api.get("/admin/dashboard/applications-trend"),
    getApplicationsStatus: () => api.get("/admin/dashboard/applications-status"),
    getMonthlyApplications: () => api.get("/admin/dashboard/monthly-applications"),
    getRecentActivity: () => api.get("/admin/dashboard/recent-activity"),
}

export const adminStudentsAPI = {
    getAll: (page = 1, perPage = 10) => api.get("/admin/students", {params: {page, per_page: perPage}}),
    getOne: (id) => api.get(`/admin/students/${id}`),
    update: (data) => api.post("/admin/students", data),
}

export default api
