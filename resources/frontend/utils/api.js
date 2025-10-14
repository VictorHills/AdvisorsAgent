const API_BASE_URL = "/api"

export const api = {
    async request(endpoint, options = {}) {
        const token = localStorage.getItem("auth_token")

        const headers = {
            "Content-Type": "application/json",
            Accept: "application/json",
            ...(token && {Authorization: `Bearer ${token}`}),
            ...options.headers,
        }

        try {
            const response = await fetch(`${API_BASE_URL}${endpoint}`, {
                ...options,
                headers,
            })

            const data = await response.json()

            if (!response.ok) {
                throw new Error(data.error || data.message || "Request failed")
            }

            return data
        } catch (error) {
            console.error("[v0] API Error:", error)
            throw error
        }
    },

    async login(credentials) {
        const data = await this.request("/auth/login", {
            method: "POST",
            body: JSON.stringify(credentials),
        })

        if (data.token) {
            localStorage.setItem("auth_token", data.token)
        }

        return data
    },

    async register(userData) {
        const data = await this.request("/auth/register", {
            method: "POST",
            body: JSON.stringify(userData),
        })

        if (data.token) {
            localStorage.setItem("auth_token", data.token)
        }

        return data
    },

    async logout() {
        try {
            await this.request("/logout", {method: "GET"})
        } finally {
            localStorage.removeItem("auth_token")
        }
    },

    async getApplications() {
        return this.request("/applications", {
            method: "GET",
        })
    },

    async createApplication(applicationData) {
        return this.request("/applications", {
            method: "POST",
            body: JSON.stringify(applicationData),
        })
    },

    async getCourses() {
        return this.request("/courses", {
            method: "GET",
        })
    },

    async getSchools() {
        return this.request("/schools", {
            method: "GET",
        })
    },
}
