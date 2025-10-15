<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <Navigation/>

        <main class="container mx-auto px-6 py-8 max-w-4xl">
            <form @submit.prevent="handleSubmit" class="space-y-8">
                <!-- Display error message if submission fails -->
                <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                    {{ error }}
                </div>

                <!-- Display success message -->
                <div v-if="success"
                     class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-500 text-sm">
                    Application submitted successfully!
                </div>

                <div class="glass-card rounded-xl p-6 animate-slide-up">
                    <h2 class="text-lg font-bold mb-6">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 group">
                            <label for="first_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">First
                                Name *</label>
                            <input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="John"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="middle_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Middle
                                Name</label>
                            <input
                                id="middle_name"
                                v-model="form.middle_name"
                                type="text"
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="Optional"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="last_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Last
                                Name *</label>
                            <input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="Doe"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="gender"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Gender
                                *</label>
                            <select
                                id="gender"
                                v-model="form.gender"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            >
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="space-y-2 group">
                            <label for="email"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Email
                                *</label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="student@email.com"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="phone_number"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Phone
                                Number *</label>
                            <input
                                id="phone_number"
                                v-model="form.phone_number"
                                type="tel"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="+1234567890"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="country"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Country
                                of Origin *</label>
                            <input
                                id="country"
                                v-model="form.country"
                                type="text"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                placeholder="Nigeria"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="class_of_degree"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Class
                                of Degree *</label>
                            <select
                                id="class_of_degree"
                                v-model="form.class_of_degree"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            >
                                <option value="">Select class</option>
                                <option value="First Class">First Class</option>
                                <option value="Second Class Upper">Second Class Upper</option>
                                <option value="Second Class Lower">Second Class Lower</option>
                                <option value="Third Class">Third Class</option>
                                <option value="Pass">Pass</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.1s;">
                    <h2 class="text-lg font-bold mb-6">Academic Preferences</h2>
                    <div class="space-y-6">
                        <div class="space-y-2 group">
                            <label for="course_id"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Desired
                                Course *</label>
                            <select
                                id="course_id"
                                v-model="form.course_id"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            >
                                <option value="">Select a course</option>
                                <!-- Populate courses from API -->
                                <option v-for="course in courses" :key="course.id" :value="course.id">
                                    {{ course.name }}
                                </option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Schools of Choice *</label>
                            <div class="space-y-2">
                                <input
                                    v-for="(school, index) in form.schools_of_choice"
                                    :key="index"
                                    v-model="form.schools_of_choice[index]"
                                    type="text"
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    :placeholder="`School ${index + 1}`"
                                />
                            </div>
                            <button
                                type="button"
                                @click="addSchool"
                                class="text-sm text-primary hover:underline transition-all"
                            >
                                + Add another school
                            </button>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium">Country Preferences *</label>
                            <div class="space-y-2">
                                <input
                                    v-for="(country, index) in form.country_of_preference"
                                    :key="index"
                                    v-model="form.country_of_preference[index]"
                                    type="text"
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    :placeholder="`Country ${index + 1}`"
                                />
                            </div>
                            <button
                                type="button"
                                @click="addCountry"
                                class="text-sm text-primary hover:underline transition-all"
                            >
                                + Add another country
                            </button>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.2s;">
                    <h2 class="text-lg font-bold mb-6">Additional Information</h2>
                    <div class="space-y-6">
                        <div class="space-y-2 group">
                            <label for="additional_notes"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Additional
                                Notes</label>
                            <textarea
                                id="additional_notes"
                                v-model="form.additional_notes"
                                rows="4"
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Any additional information about the student..."
                            ></textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="documents" class="text-sm font-medium">Application Documents</label>
                            <div
                                class="border-2 border-dashed border-border rounded-lg p-8 text-center hover:border-primary transition-all duration-300 cursor-pointer">
                                <svg class="w-12 h-12 mx-auto text-muted-foreground mb-4" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-muted-foreground mb-2">Click to upload or drag and drop</p>
                                <p class="text-xs text-muted-foreground">PDF, DOC, DOCX (max. 10MB)</p>
                                <input
                                    id="documents"
                                    type="file"
                                    multiple
                                    class="hidden"
                                    @change="handleFileUpload"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 animate-slide-up" style="animation-delay: 0.3s;">
                    <router-link
                        to="/dashboard"
                        class="px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted transition-all duration-200 hover:scale-105"
                    >
                        Cancel
                    </router-link>
                    <!-- Disable button while loading -->
                    <button
                        type="submit"
                        :disabled="loading"
                        class="px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ loading ? 'Submitting...' : 'Submit Application' }}
                    </button>
                </div>
            </form>
        </main>
    </div>
</template>

<script>
import {ref, onMounted} from 'vue';
import {useRouter} from 'vue-router';
import {useTheme} from '../composables/useTheme';
import {applicationsAPI, coursesAPI} from '../services/api';
import Navigation from '../components/Navigation.vue';

export default {
    name: 'CreateApplication',
    components: {
        Navigation
    },
    setup() {
        const router = useRouter();
        const {isDark, toggleTheme} = useTheme();

        const loading = ref(false);
        const error = ref(null);
        const success = ref(false);
        const courses = ref([]);

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
            schools_of_choice: ['', '', ''],
            country_of_preference: ['', ''],
            additional_notes: '',
            application_documents: []
        });

        const fetchCourses = async () => {
            try {
                const response = await coursesAPI.getAll();
                courses.value = response.data;
            } catch (err) {
                console.error('[v0] Error fetching courses:', err);
            }
        };

        const addSchool = () => {
            form.value.schools_of_choice.push('');
        };

        const addCountry = () => {
            form.value.country_of_preference.push('');
        };

        const handleFileUpload = (event) => {
            const files = Array.from(event.target.files);
            form.value.application_documents = files;
        };

        const handleSubmit = async () => {
            try {
                loading.value = true;
                error.value = null;
                success.value = false;

                const applicationData = {
                    ...form.value,
                    schools_of_choice: form.value.schools_of_choice.filter(s => s.trim() !== ''),
                    country_of_preference: form.value.country_of_preference.filter(c => c.trim() !== '')
                };

                await applicationsAPI.create(applicationData);

                success.value = true;
                setTimeout(() => {
                    router.push('/dashboard');
                }, 2000);
            } catch (err) {
                console.error('[v0] Error submitting application:', err);
                error.value = err.response?.data?.message || 'Failed to submit application';
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchCourses();
        });

        return {
            form,
            courses,
            loading,
            error,
            success,
            addSchool,
            addCountry,
            handleFileUpload,
            handleSubmit,
            isDark,
            toggleTheme
        };
    }
};
</script>
