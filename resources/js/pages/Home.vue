<template>
    <div class="min-h-screen flex">
        Left Side - Form
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-background">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight">Welcome back</h2>
                    <p class="mt-2 text-muted-foreground">Sign in to your agent account</p>
                </div>

                <form @submit.prevent="handleLogin" class="space-y-6">
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium">Email</label>
                            <input
                                id="email"
                                v-model="loginForm.email"
                                type="email"
                                required
                                class="w-full px-3 py-2 border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                placeholder="agent@example.com"
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium">Password</label>
                            <input
                                id="password"
                                v-model="loginForm.password"
                                type="password"
                                required
                                class="w-full px-3 py-2 border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" v-model="loginForm.remember" class="rounded border-input" />
                            <span class="text-sm">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-primary hover:underline">Forgot password?</a>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2 px-4 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 font-medium transition-colors"
                    >
                        Sign in
                    </button>

                    <p class="text-center text-sm text-muted-foreground">
                        Don't have an account?
                        <a href="/register" class="text-primary hover:underline font-medium">Register here</a>
                    </p>
                </form>
            </div>
        </div>

        Right Side - Image
        <div class="hidden lg:block lg:w-1/2 relative bg-muted">
            <img
                alt="Students studying"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-background/80 to-background/20" />
            <div class="absolute bottom-0 left-0 right-0 p-12 text-foreground">
                <h3 class="text-3xl font-bold mb-4">Manage Student Applications</h3>
                <p class="text-lg opacity-90">Streamline your student recruitment process with our comprehensive management system.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const loginForm = ref({
    email: '',
    password: '',
    remember: false
})

const handleLogin = () => {
    console.log('[v0] Login attempt:', loginForm.value)
    // Add authentication logic here
    alert('Login functionality - integrate with your backend')
}
</script>
