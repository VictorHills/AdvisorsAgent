<template>
    <div class="min-h-screen flex">
        <div class="hidden lg:flex flex-1 bg-primary/5 items-center justify-center p-12">
            <div class="max-w-lg">
                <img
                    src="/placeholder.svg?height=600&width=600"
                    alt="Education advisors"
                    class="w-full h-auto rounded-2xl shadow-2xl"
                />
                <div class="mt-8 text-center">
                    <h2 class="text-2xl font-bold text-balance mb-3">Join Our Network</h2>
                    <p class="text-muted-foreground text-pretty">
                        Connect students with their dream schools and grow your education agency
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-8 lg:p-12 overflow-y-auto">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-balance mb-3">Create account</h1>
                    <p class="text-muted-foreground text-lg">Start managing student applications</p>
                </div>

                <form @submit.prevent="handleRegister" class="space-y-5">
                    <div v-if="error" class="p-4 bg-destructive/10 border border-destructive/20 rounded-lg">
                        <p class="text-sm text-destructive">{{ error }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="first_name" class="text-sm font-medium">First Name</label>
                            <input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                placeholder="John"
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="last_name" class="text-sm font-medium">Last Name</label>
                            <input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                placeholder="Doe"
                            />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="agency_name" class="text-sm font-medium">Agency Name</label>
                        <input
                            id="agency_name"
                            v-model="form.agency_name"
                            type="text"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            placeholder="Your Education Agency"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="business_registration_number" class="text-sm font-medium">
                            Business Registration Number
                        </label>
                        <input
                            id="business_registration_number"
                            v-model="form.business_registration_number"
                            type="text"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            placeholder="123456789"
                        />
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
                            minlength="6"
                            class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            placeholder="••••••••"
                        />
                    </div>

                    <div class="flex items-start gap-3">
                        <input
                            id="terms"
                            v-model="form.is_terms_and_condition_accepted"
                            type="checkbox"
                            required
                            class="mt-1 w-4 h-4 rounded border-input text-primary focus:ring-2 focus:ring-ring"
                        />
                        <label for="terms" class="text-sm text-muted-foreground">
                            I agree to the terms and conditions and privacy policy
                        </label>
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-3 px-4 bg-primary text-primary-foreground rounded-lg font-medium hover:opacity-90 transition-opacity disabled:opacity-50"
                    >
                        {{ loading ? 'Creating account...' : 'Create account' }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-muted-foreground">
                        Already have an account?
                        <router-link to="/login" class="text-primary font-medium hover:underline">
                            Sign in
                        </router-link>
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
    first_name: '',
    last_name: '',
    agency_name: '',
    business_registration_number: '',
    email: '',
    password: '',
    role_name: 'agent',
    is_terms_and_condition_accepted: false
})
const loading = ref(false)
const error = ref('')

const handleRegister = async () => {
    loading.value = true
    error.value = ''

    try {
        await api.register(form.value)
        router.push('/dashboard')
    } catch (err) {
        error.value = err.message || 'Registration failed. Please try again.'
    } finally {
        loading.value = false
    }
}
</script>
