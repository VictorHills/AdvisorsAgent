<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8 max-w-4xl">
            <div class="glass-card rounded-xl p-8 animate-slide-up">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold mb-2">Verify Your Email</h1>
                    <p class="text-muted-foreground">Enter your email to get started</p>
                </div>

                <!-- Step 1: Email Input -->
                <div v-if="!otpSent" class="space-y-6">
                    <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="email" class="text-sm font-medium">Email Address *</label>
                        <input
                            id="email"
                            v-model="email"
                            type="email"
                            required
                            :disabled="loading"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            placeholder="student@email.com"
                            @keyup.enter="handleEmailSubmit"
                        />
                    </div>

                    <button
                        @click="handleEmailSubmit"
                        :disabled="loading || !email"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
            <span v-if="loading" class="flex items-center gap-2">
              <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Verifying...
            </span>
                        <span v-else>Search & Verify</span>
                    </button>
                </div>

                <!-- Step 2: OTP Verification (for new students) -->
                <div v-else-if="!isExisting && !verified" class="space-y-6">
                    <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                        <p class="text-sm text-green-600">OTP sent to {{ email }}. Check your email for the verification code.</p>
                    </div>

                    <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="otp" class="text-sm font-medium">Verification Code *</label>
                        <input
                            id="otp"
                            v-model="otp"
                            type="text"
                            required
                            :disabled="loading"
                            maxlength="6"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed text-center text-lg tracking-widest"
                            placeholder="000000"
                            @keyup.enter="handleOtpSubmit"
                        />
                    </div>

                    <button
                        @click="handleOtpSubmit"
                        :disabled="loading || !otp"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
            <span v-if="loading" class="flex items-center gap-2">
              <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Verifying...
            </span>
                        <span v-else>Verify Code</span>
                    </button>

                    <button
                        @click="resetVerification"
                        :disabled="loading"
                        class="w-full px-6 py-3 bg-transparent border border-border text-foreground rounded-lg font-medium hover:bg-muted transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Back to Email
                    </button>
                </div>

                <!-- Step 3: Verification Complete -->
                <div v-else-if="verified" class="space-y-6 text-center">
                    <div class="flex justify-center">
                        <svg class="w-16 h-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold mb-2">Verification Successful</h2>
                        <p class="text-muted-foreground">{{ isExisting ? 'Student found. Proceeding with your profile...' : 'Email verified. Complete your profile...' }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { ref } from 'vue'
import {authAPI, studentsAPI} from '../services/api'

export default {
    name: 'EmailVerification',
    emits: ['verified'],
    setup(props, { emit }) {
        const email = ref('')
        const otp = ref('')
        const loading = ref(false)
        const error = ref('')
        const otpSent = ref(false)
        const isExisting = ref(false)
        const verified = ref(false)
        const studentData = ref(null)
        const destination = 'email';

        const handleEmailSubmit = async () => {
            try {
                loading.value = true
                error.value = ''

                const response = await studentsAPI.validateStudent(email.value)

                if (response.data?.status) {
                    // Student exists
                    isExisting.value = true
                    studentData.value = response.data.data
                    verified.value = true

                    // Emit immediately for existing students
                    emit('verified', {
                        isExisting: true,
                        email: email.value,
                        student: studentData.value,
                    })
                } else {
                    error.value = response.data?.error?.message || 'Unable to process email'
                }
            } catch (err) {
                if (err.response?.data?.error?.status_code === 400) {
                    // New student - OTP sent
                    isExisting.value = false
                    otpSent.value = true
                    error.value = ''
                } else {
                    error.value = err.response?.data?.error?.message || 'Failed to verify email'
                }
            } finally {
                loading.value = false
            }
        }

        const handleOtpSubmit = async () => {
            try {
                loading.value = true
                error.value = ''

                const response = await authAPI.verifyOtp(email.value, otp.value, destination)

                if (response.data?.status) {
                    verified.value = true

                    // Emit after OTP verification
                    emit('verified', {
                        isExisting: false,
                        email: email.value,
                        student: null,
                    })
                } else {
                    error.value = response.data?.message || 'OTP verification failed'
                }
            } catch (err) {
                error.value = err.response?.data?.message || 'Invalid verification code'
            } finally {
                loading.value = false
            }
        }

        const resetVerification = () => {
            email.value = ''
            otp.value = ''
            otpSent.value = false
            isExisting.value = false
            verified.value = false
            error.value = ''
        }

        return {
            email,
            otp,
            destination,
            loading,
            error,
            otpSent,
            isExisting,
            verified,
            handleEmailSubmit,
            handleOtpSubmit,
            resetVerification,
        }
    }
}
</script>
