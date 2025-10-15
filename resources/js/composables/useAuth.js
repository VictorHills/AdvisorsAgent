"use client"

import {ref, computed} from "vue"
import {useRouter} from "vue-router"
import {authAPI} from "../services/api"

const user = ref(null)
const token = ref(null)
const loading = ref(false)
const error = ref(null)

export function useAuth() {
    const router = useRouter()

    const isAuthenticated = computed(() => !!token.value)

    const initAuth = () => {
        const savedToken = localStorage.getItem("auth_token")
        const savedUser = localStorage.getItem("user")

        if (savedToken && savedUser) {
            token.value = savedToken
            user.value = JSON.parse(savedUser)
        }
    }

    const login = async (credentials) => {
        loading.value = true
        error.value = null

        try {
            const response = await authAPI.login(credentials)
            const {access_token, user: userData} = response.data

            token.value = access_token
            user.value = userData

            localStorage.setItem("auth_token", access_token)
            localStorage.setItem("user", JSON.stringify(userData))

            router.push("/dashboard")
            return {success: true}
        } catch (err) {
            error.value = err.response?.data?.message || "Login failed"
            return {success: false, error: error.value}
        } finally {
            loading.value = false
        }
    }

    const register = async (userData) => {
        loading.value = true
        error.value = null

        try {
            const response = await authAPI.register(userData)
            const {access_token, user: newUser} = response.data

            token.value = access_token
            user.value = newUser

            localStorage.setItem("auth_token", access_token)
            localStorage.setItem("user", JSON.stringify(newUser))

            router.push("/dashboard")
            return {success: true}
        } catch (err) {
            error.value = err.response?.data?.message || "Registration failed"
            return {success: false, error: error.value}
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
            user.value = response.data
            localStorage.setItem("user", JSON.stringify(response.data))
        } catch (err) {
            console.error("Fetch user error:", err)
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
