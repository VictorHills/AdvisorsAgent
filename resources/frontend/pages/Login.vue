<template>
    <div class="min-h-screen flex">
        <div class="flex-1 flex items-center justify-center p-8 lg:p-12">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-balance mb-3">Welcome back</h1>
                    <p class="text-muted-foreground text-lg">Sign in to your agent account</p>
                </div>

                <form @submit.prevent="handleLogin" class="space-y-6">
                    <div v-if="error" class="p-4 bg-destructive/10 border border-destructive/20 rounded-lg">
                        <p class="text-sm text-destructive">{{ error }}</p>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            placeholder="agent@example.com"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            placeholder="••••••••"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-3 px-4 bg-primary text-primary-foreground rounded-lg font-medium hover:opacity-90 transition-opacity disabled:opacity-50"
                    >
                        {{ loading ? 'Signing in...' : 'Sign in' }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-muted-foreground">
                        Don't have an account?
                        <router-link to="/register" class="text-primary font-medium hover:underline">
                            Register here
                        </router-link>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex flex-1 bg-primary/5 items-center justify-center p-12">
            <div class="max-w-lg">
                <img
                    src="/placeholder.svg?height=600&width=600"
                    alt="Education platform"
                    class="w-full h-auto rounded-2xl shadow-2xl"
                />
                <div class="mt-8 text-center">
                    <h2 class="text-2xl font-bold text-balance mb-3">Manage Student Applications</h2>
                    <p class="text-muted-foreground text-pretty">
                        Streamline your education agency workflow with our comprehensive platform
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../utils/api'

const router = useRouter()
const form = ref({
    email: '',
    password: ''
})
const loading = ref(false)
const error = ref('')

const handleLogin = async () => {
    loading.value = true
    error.value = ''

    try {
        await api.login(form.value)
        router.push('/dashboard')
    } catch (err) {
        error.value = err.message || 'Invalid credentials. Please try again.'
    } finally {
        loading.value = false
    }
}
</script>
