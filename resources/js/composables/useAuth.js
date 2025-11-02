"use client"

import {computed, ref} from "vue"
import {useRouter} from "vue-router"
import {authAPI} from "../services/api"

const user = ref(null)
const token = ref(null)
const loading = ref(false)
const error = ref(null)

export function useAuth() {
    const router = useRouter()

    const isAuthenticated = computed(() => !!token.value && !!user.value)

    const initAuth = () => {
        const savedToken = localStorage.getItem("auth_token")
        const savedUser = localStorage.getItem("user")

        if (savedToken && savedUser) {
            token.value = savedToken
            try {
                user.value = JSON.parse(savedUser)
            } catch (e) {
                localStorage.removeItem("auth_token")
                localStorage.removeItem("user")
                token.value = null
                user.value = null
            }
        }
    }

    const login = async (credentials) => {
        loading.value = true
        error.value = null

        try {
            const response = await authAPI.login(credentials)
            const {token: authToken, user: userData} = response.data

            if (!authToken || !userData) {
                throw new Error("Invalid response from server")
            }

            token.value = authToken
            user.value = userData

            localStorage.setItem("auth_token", authToken)
            localStorage.setItem("user", JSON.stringify(userData))

            await router.push("/dashboard")
            return {success: true}
        } catch (err) {
            const errorMessage = err.response?.data?.error || err.response?.data?.message || "Login failed"
            error.value = errorMessage

            token.value = null
            user.value = null
            localStorage.removeItem("auth_token")
            localStorage.removeItem("user")

            return {success: false, error: errorMessage}
        } finally {
            loading.value = false
        }
    }

    const register = async (userData) => {
        loading.value = true
        error.value = null

        try {
            const { data } = await authAPI.register(userData)
            const { user: newUser, message } = data

            // Validate response
            if (!newUser) {
                throw new Error("Invalid response from server")
            }

            // Save user temporarily if you want — optional
            user.value = newUser
            localStorage.setItem("user", JSON.stringify(newUser))

            // Redirect to login page since user isn't logged in
            await router.push("/login")

            return { success: true, message }
        } catch (err) {
            const errorMessage =
                err.response?.data?.error ||
                err.response?.data?.message ||
                err.message ||
                "Registration failed"

            error.value = errorMessage

            // Clean up
            user.value = null
            localStorage.removeItem("user")

            return { success: false, error: errorMessage }
        } finally {
            loading.value = false
        }
    }

    const logout = async () => {
        try {
            await authAPI.logout()
        } catch (err) {
            console.error("Logout error:", err)
        } finally {
            token.value = null
            user.value = null
            localStorage.removeItem("auth_token")
            localStorage.removeItem("user")
            router.push("/login")
        }
    }

    const fetchUser = async () => {
        try {
            const response = await authAPI.getUser()
            user.value = response.data.user
            localStorage.setItem("user", JSON.stringify(response.data.user))
        } catch (err) {
            console.error("Fetch user error:", err)
            token.value = null
            user.value = null
            localStorage.removeItem("auth_token")
            localStorage.removeItem("user")
        }
    }

    return {
        user,
        token,
        loading,
        error,
        isAuthenticated,
        initAuth,
        login,
        register,
        logout,
        fetchUser,
    }
}
