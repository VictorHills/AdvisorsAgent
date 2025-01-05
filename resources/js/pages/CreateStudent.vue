<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8 max-w-4xl">

            <!-- Step 1: Email Verification -->
            <div v-if="!isVerified" class="glass-card rounded-xl p-8 animate-slide-up">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold mb-2">Verify Your Email</h1>
                    <p class="text-muted-foreground">Enter your email to create a student profile</p>
                </div>

                <!-- Email Input -->
                <div v-if="!otpSent" class="space-y-6">
                    <div v-if="error"
                         class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="email" class="text-sm font-medium">Email Address *</label>
                        <input
                            id="email"
                            v-model="verificationEmail"
                            type="email"
                            required
                            :disabled="verifyLoading"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            placeholder="student@email.com"
                            @keyup.enter="handleEmailSubmit"
                        />
                    </div>

                    <button
                        @click="handleEmailSubmit"
                        :disabled="verifyLoading || !verificationEmail"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span v-if="verifyLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                        <span v-else>Search & Verify</span>
                    </button>
                </div>

                <!-- OTP Verification (for new students) -->
                <div v-else class="space-y-6">
                    <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                        <p class="text-sm text-green-600">OTP sent to {{ verificationEmail }}. Check your email for the
                            verification code.</p>
                    </div>

                    <div v-if="error"
                         class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="otp" class="text-sm font-medium">Verification Code *</label>
                        <input
                            id="otp"
                            v-model="otp"
                            type="text"
                            required
                            :disabled="verifyLoading"
                            maxlength="6"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed text-center text-lg tracking-widest"
                            placeholder="000000"
                            @keyup.enter="handleOtpSubmit"
                        />
                    </div>

                    <button
                        @click="handleOtpSubmit"
                        :disabled="verifyLoading || !otp"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span v-if="verifyLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                        <span v-else>Verify Code</span>
                    </button>

                    <button
                        @click="resetVerification"
                        :disabled="verifyLoading"
                        class="w-full px-6 py-3 bg-transparent border border-border text-foreground rounded-lg font-medium hover:bg-muted transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Back to Email
                    </button>
                </div>
            </div>

            <!-- Step 2: Student Form (after verification) -->
            <form v-else @submit.prevent="handleSubmit" class="space-y-8 animate-fade-in">
                <!-- Existing Student Banner -->
                <div v-if="isExistingStudent" class="p-4 bg-blue-500/10 border border-blue-500/30 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-600">Existing Student Found</p>
                            <p class="text-xs text-blue-500/80">Your information has been prefilled. You can only edit
                                certain fields.</p>
                        </div>
                    </div>
                </div>

                <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                    {{ error }}
                </div>

                <div v-if="success" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-card rounded-xl p-8 text-center border border-border shadow-2xl animate-scale-in">
                        <svg class="w-16 h-16 text-emerald-500 mx-auto mb-4 animate-spin" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <h3 class="text-xl font-bold mb-2">{{ successMessage }}</h3>
                        <p class="text-muted-foreground text-sm">Redirecting to dashboard...</p>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="glass-card rounded-xl p-6 animate-slide-up">
                    <h2 class="text-lg font-bold mb-6">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 group">
                            <label for="first_name" class="text-sm font-medium">First Name *</label>
                            <input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="John"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="middle_name" class="text-sm font-medium">Middle Name</label>
                            <input
                                id="middle_name"
                                v-model="form.middle_name"
                                type="text"
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="Optional"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="last_name" class="text-sm font-medium">Last Name *</label>
                            <input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="Doe"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="gender" class="text-sm font-medium">Gender *</label>
                            <select
                                id="gender"
                                v-model="form.gender"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                            >
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="space-y-2 group">
                            <label for="email" class="text-sm font-medium">Email *</label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                disabled
                                class="w-full px-4 py-3 bg-muted/50 border border-border rounded-lg cursor-not-allowed opacity-75"
                                placeholder="student@email.com"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="phone_number" class="text-sm font-medium">Phone Number *</label>
                            <input
                                id="phone_number"
                                v-model="form.phone_number"
                                type="tel"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="+1234567890"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="country" class="text-sm font-medium">Country *</label>
                            <input
                                id="country"
                                v-model="form.country"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="United States"
                            />
                        </div>

                        <DatePickerField
                            id="birth_date"
                            v-model="form.birth_date"
                            label="Date of Birth"
                            :required="true"
                            :disabled="isExistingStudent"
                            :max-date="maxBirthDate"
                            :class="isExistingStudent ? 'opacity-75' : ''"
                        />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-6">
                    <router-link to="/students"
                                 class="flex-1 px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted transition-all text-center">
                        Cancel
                    </router-link>
                    <button
                        type="submit"
                        :disabled="loading"
                        class="flex-1 px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span v-if="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Submitting...
                        </span>
                        <span v-else>Create Student Profile</span>
                    </button>
                </div>
            </form>
        </main>
    </div>
</template>

<script>
import {ref, computed} from 'vue'
import {useRouter} from 'vue-router'
import {authAPI, studentsAPI} from '../services/api'
import DatePickerField from '../components/DatePickerField.vue'

export default {
    name: 'CreateStudent',
    components: {DatePickerField},
    setup() {
        const router = useRouter()

        // Verification state
        const verificationEmail = ref('')
        const otp = ref('')
        const otpSent = ref(false)
        const isVerified = ref(false)
        const isExistingStudent = ref(false)
        const verifyLoading = ref(false)

        // Form state
        const error = ref('')
        const loading = ref(false)
        const success = ref(false)
        const successMessage = ref('Student profile created successfully!')

        const form = ref({
            first_name: '',
            middle_name: '',
            last_name: '',
            gender: '',
            email: '',
            phone_number: '',
            birth_date: '',
            country: '',
        })

        // Max birthdate (must be at least 16 years old)
        const maxBirthDate = computed(() => {
            const date = new Date()
            date.setFullYear(date.getFullYear() - 16)
            return date.toISOString().split('T')[0]
        })

        const handleEmailSubmit = async () => {
            try {
                verifyLoading.value = true
                error.value = ''

                const response = await studentsAPI.validateStudent(verificationEmail.value)

                if (response.data?.status) {
                    // Existing student found - prefill data
                    isExistingStudent.value = true
                    isVerified.value = true
                    const studentData = response.data.data

                    form.value.first_name = studentData.first_name || ''
                    form.value.middle_name = studentData.middle_name || ''
                    form.value.last_name = studentData.last_name || ''
                    form.value.gender = studentData.gender?.toLowerCase() || ''
                    form.value.email = studentData.email || ''
                    form.value.phone_number = studentData.phone_number || ''
                    form.value.birth_date = studentData.birth_date || ''
                    form.value.country = studentData.country || ''
                }
            } catch (err) {
                if (err.response?.data?.error?.status_code === 400) {
                    // New student - OTP sent
                    otpSent.value = true
                    error.value = ''
                } else {
                    error.value = err.response?.data?.error?.message || 'Failed to verify email'
                }
            } finally {
                verifyLoading.value = false
            }
        }

        const handleOtpSubmit = async () => {
            try {
                verifyLoading.value = true
                error.value = ''

                const response = await authAPI.verifyOtp(verificationEmail.value, otp.value, 'email')

                if (response.data?.status) {
                    // OTP verified - new student, only prefill email
                    isVerified.value = true
                    isExistingStudent.value = false
                    form.value.email = verificationEmail.value
                } else {
                    error.value = response.data?.message || 'OTP verification failed'
                }
            } catch (err) {
                error.value = err.response?.data?.message || err.response?.data?.error?.message || 'Invalid verification code'
            } finally {
                verifyLoading.value = false
            }
        }

        const resetVerification = () => {
            verificationEmail.value = ''
            otp.value = ''
            otpSent.value = false
            error.value = ''
        }

        const handleSubmit = async () => {
            try {
                loading.value = true
                error.value = null
                success.value = false

                const response = await studentsAPI.create(form.value)

                successMessage.value = response.data?.message || 'Student profile created successfully!'
                success.value = true

                setTimeout(() => {
                    router.push('/students')
                }, 2000)
            } catch (err) {
                console.error('Error creating student:', err)
                error.value = err.response?.data?.message || 'Failed to create student profile'
                setTimeout(() => error.value = null, 5000)
            } finally {
                loading.value = false
            }
        }

        return {
            verificationEmail,
            otp,
            otpSent,
            isVerified,
            isExistingStudent,
            verifyLoading,
            handleEmailSubmit,
            handleOtpSubmit,
            resetVerification,
            form,
            error,
            loading,
            success,
            successMessage,
            maxBirthDate,
            handleSubmit
        }
    }
}
</script>
