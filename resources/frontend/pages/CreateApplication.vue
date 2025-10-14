<template>
    <div class="min-h-screen bg-muted/30">
        <!-- Header -->
        <header class="bg-background border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <router-link
                            to="/dashboard"
                            class="text-muted-foreground hover:text-foreground transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </router-link>
                        <h1 class="text-xl font-bold">New Student Application</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-card rounded-lg border border-border p-8">
                <form @submit.prevent="handleSubmit" class="space-y-8">
                    <!-- Success/Error Messages -->
                    <div v-if="successMessage" class="p-4 bg-primary/10 border border-primary/20 rounded-lg">
                        <p class="text-sm text-primary">{{ successMessage }}</p>
                    </div>

                    <div v-if="errorMessage" class="p-4 bg-destructive/10 border border-destructive/20 rounded-lg">
                        <p class="text-sm text-destructive">{{ errorMessage }}</p>
                    </div>

                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Personal Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label for="first_name" class="text-sm font-medium">
                                    First Name <span class="text-destructive">*</span>
                                </label>
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
                                <label for="middle_name" class="text-sm font-medium">Middle Name</label>
                                <input
                                    id="middle_name"
                                    v-model="form.middle_name"
                                    type="text"
                                    class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                    placeholder="Michael"
                                />
                            </div>

                            <div class="space-y-2">
                                <label for="last_name" class="text-sm font-medium">
                                    Last Name <span class="text-destructive">*</span>
                                </label>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="gender" class="text-sm font-medium">
                                    Gender <span class="text-destructive">*</span>
                                </label>
                                <select
                                    id="gender"
                                    v-model="form.gender"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                >
                                    <option value="">Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="country" class="text-sm font-medium">
                                    Country <span class="text-destructive">*</span>
                                </label>
                                <input
                                    id="country"
                                    v-model="form.country"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                    placeholder="United States"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Contact Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium">
                                    Email <span class="text-destructive">*</span>
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                    placeholder="student@example.com"
                                />
                            </div>

                            <div class="space-y-2">
                                <label for="phone_number" class="text-sm font-medium">
                                    Phone Number <span class="text-destructive">*</span>
                                </label>
                                <input
                                    id="phone_number"
                                    v-model="form.phone_number"
                                    type="tel"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                    placeholder="+1 234 567 8900"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Academic Information</h2>

                        <div class="space-y-2">
                            <label for="class_of_degree" class="text-sm font-medium">
                                Class of Degree <span class="text-destructive">*</span>
                            </label>
                            <select
                                id="class_of_degree"
                                v-model="form.class_of_degree"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            >
                                <option value="">Select degree class</option>
                                <option value="First Class">First Class</option>
                                <option value="Second Class Upper">Second Class Upper</option>
                                <option value="Second Class Lower">Second Class Lower</option>
                                <option value="Third Class">Third Class</option>
                                <option value="Pass">Pass</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="course_id" class="text-sm font-medium">
                                Course <span class="text-destructive">*</span>
                            </label>
                            <select
                                id="course_id"
                                v-model="form.course_id"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                            >
                                <option value="">Select a course</option>
                                <option v-for="course in courses" :key="course.id" :value="course.id">
                                    {{ course.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Preferences</h2>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">
                                Schools of Choice <span class="text-destructive">*</span>
                            </label>
                            <div class="space-y-2">
                                <div v-for="(school, index) in form.schools_of_choice" :key="index" class="flex gap-2">
                                    <select
                                        v-model="form.schools_of_choice[index]"
                                        required
                                        class="flex-1 px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                    >
                                        <option value="">Select school {{ index + 1 }}</option>
                                        <option v-for="school in schools" :key="school.id" :value="school.id">
                                            {{ school.name }}
                                        </option>
                                    </select>
                                    <button
                                        v-if="form.schools_of_choice.length > 1"
                                        type="button"
                                        @click="removeSchool(index)"
                                        class="px-4 py-3 text-destructive hover:bg-destructive/10 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    @click="addSchool"
                                    class="text-sm text-primary hover:underline"
                                >
                                    + Add another school
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">
                                Country of Preference <span class="text-destructive">*</span>
                            </label>
                            <div class="space-y-2">
                                <div v-for="(country, index) in form.country_of_preference" :key="index" class="flex gap-2">
                                    <input
                                        v-model="form.country_of_preference[index]"
                                        type="text"
                                        required
                                        class="flex-1 px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                        :placeholder="`Country ${index + 1}`"
                                    />
                                    <button
                                        v-if="form.country_of_preference.length > 1"
                                        type="button"
                                        @click="removeCountry(index)"
                                        class="px-4 py-3 text-destructive hover:bg-destructive/10 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    @click="addCountry"
                                    class="text-sm text-primary hover:underline"
                                >
                                    + Add another country
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Documents</h2>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">
                                Application Documents <span class="text-destructive">*</span>
                            </label>
                            <p class="text-sm text-muted-foreground mb-2">
                                Upload required documents (transcripts, certificates, etc.)
                            </p>
                            <div class="space-y-2">
                                <div v-for="(doc, index) in form.application_documents" :key="index" class="flex gap-2">
                                    <input
                                        v-model="form.application_documents[index]"
                                        type="text"
                                        required
                                        class="flex-1 px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                        :placeholder="`Document URL ${index + 1}`"
                                    />
                                    <button
                                        v-if="form.application_documents.length > 1"
                                        type="button"
                                        @click="removeDocument(index)"
                                        class="px-4 py-3 text-destructive hover:bg-destructive/10 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    @click="addDocument"
                                    class="text-sm text-primary hover:underline"
                                >
                                    + Add another document
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold border-b border-border pb-2">Additional Information</h2>

                        <div class="space-y-2">
                            <label for="additional_notes" class="text-sm font-medium">Additional Notes</label>
                            <textarea
                                id="additional_notes"
                                v-model="form.additional_notes"
                                rows="4"
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                                placeholder="Any additional information or special requirements..."
                            ></textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="signature" class="text-sm font-medium">Signature</label>
                            <input
                                id="signature"
                                v-model="form.signature"
                                type="text"
                                class="w-full px-4 py-3 rounded-lg border border-input bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                                placeholder="Type your full name as signature"
                            />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            :disabled="loading"
                            class="flex-1 py-3 px-4 bg-primary text-primary-foreground rounded-lg font-medium hover:opacity-90 transition-opacity disabled:opacity-50"
                        >
                            {{ loading ? 'Submitting...' : 'Submit Application' }}
                        </button>
                        <router-link
                            to="/dashboard"
                            class="px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted/50 transition-colors"
                        >
                            Cancel
                        </router-link>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../utils/api'

const router = useRouter()

const form = ref({
    first_name: '',
    middle_name: '',
    last_name: '',
    gender: '',
    email: '',
    phone_number: '',
    country: '',
    class_of_degree: '',
    course_id: '',
    schools_of_choice: [''],
    country_of_preference: [''],
    application_documents: [''],
    additional_notes: '',
    signature: ''
})

const courses = ref([])
const schools = ref([])
const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const fetchData = async () => {
    try {
        console.log('[v0] Fetching courses and schools...')

        // Simulate API calls - replace with actual API when backend is ready
        await new Promise(resolve => setTimeout(resolve, 500))

        // Mock data
        courses.value = [
            { id: 1, name: 'Computer Science' },
            { id: 2, name: 'Business Administration' },
            { id: 3, name: 'Engineering' },
            { id: 4, name: 'Medicine' },
            { id: 5, name: 'Law' }
        ]

        schools.value = [
            { id: 1, name: 'Harvard University' },
            { id: 2, name: 'Stanford University' },
            { id: 3, name: 'MIT' },
            { id: 4, name: 'Oxford University' },
            { id: 5, name: 'Cambridge University' }
        ]
    } catch (error) {
        console.error('[v0] Error fetching data:', error)
        errorMessage.value = 'Failed to load form data. Please refresh the page.'
    }
}

const addSchool = () => {
    form.value.schools_of_choice.push('')
}

const removeSchool = (index) => {
    form.value.schools_of_choice.splice(index, 1)
}

const addCountry = () => {
    form.value.country_of_preference.push('')
}

const removeCountry = (index) => {
    form.value.country_of_preference.splice(index, 1)
}

const addDocument = () => {
    form.value.application_documents.push('')
}

const removeDocument = (index) => {
    form.value.application_documents.splice(index, 1)
}

const handleSubmit = async () => {
    loading.value = true
    successMessage.value = ''
    errorMessage.value = ''

    try {
        console.log('[v0] Submitting application:', form.value)

        // Prepare data for submission
        const applicationData = {
            ...form.value,
            // Filter out empty values from arrays
            schools_of_choice: form.value.schools_of_choice.filter(s => s),
            country_of_preference: form.value.country_of_preference.filter(c => c),
            application_documents: form.value.application_documents.filter(d => d)
        }

        // This will be implemented when the backend API is ready
        // await api.createApplication(applicationData)

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))

        successMessage.value = 'Application submitted successfully!'

        // Redirect to dashboard after 2 seconds
        setTimeout(() => {
            router.push('/dashboard')
        }, 2000)
    } catch (error) {
        console.error('[v0] Error submitting application:', error)
        errorMessage.value = error.message || 'Failed to submit application. Please try again.'
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchData()
})
</script>
