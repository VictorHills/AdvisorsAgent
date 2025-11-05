<template>
    <div class="min-h-screen bg-background animate-fade-in">

        <main class="container mx-auto px-6 py-8 max-w-4xl">
            <form @submit.prevent="handleSubmit" class="space-y-8">
                <!-- Display error message if submission fails -->
                <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                    {{ error }}
                </div>

                <!-- Display success message from endpoint with auto-redirect -->
                <div v-if="success"
                     class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-500 text-sm">
                    {{ successMessage }}
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
                        <!-- Desired Course with searchable dropdown -->
                        <div class="space-y-2 group">
                            <label for="course_search"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Desired
                                Course *</label>
                            <div class="relative">
                                <input
                                    id="course_search"
                                    v-model="courseSearch"
                                    type="text"
                                    placeholder="Search and select a course..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleCourseFocus"
                                    @blur="handleCourseBlur"
                                />
                                <div v-if="showCourseDropdown" class="absolute z-10 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredCourses.length === 0" class="p-3 text-sm text-muted-foreground">
                                        No courses found
                                    </div>
                                    <div
                                        v-for="course in filteredCourses"
                                        :key="course.id"
                                        @click="form.course_id = course.id; courseSearch = course.name; showCourseDropdown = false"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors"
                                    >
                                        {{ course.name }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.course_id" class="mt-2 text-sm text-muted-foreground">
                                Selected: {{ getCourseName(form.course_id) }}
                            </div>
                        </div>

                        <!-- Schools of Choice multi-select with search -->
                        <div class="space-y-2">
                            <label for="school_search"
                                   class="text-sm font-medium">Schools of Choice *</label>
                            <div class="relative">
                                <input
                                    id="school_search"
                                    v-model="schoolSearch"
                                    type="text"
                                    placeholder="Search and select schools..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleSchoolFocus"
                                    @blur="handleSchoolBlur"
                                />
                                <div v-if="showSchoolDropdown" class="absolute z-10 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredSchools.length === 0" class="p-3 text-sm text-muted-foreground">
                                        No schools found
                                    </div>
                                    <div
                                        v-for="school in filteredSchools"
                                        :key="school.id"
                                        @click="toggleSchool(school.id)"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors flex items-center"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="form.schools_of_choice.includes(school.id)"
                                            class="mr-2"
                                            @change="toggleSchool(school.id)"
                                        />
                                        {{ school.name }}
                                    </div>
                                </div>
                            </div>
                            <!-- Display selected schools -->
                            <div v-if="form.schools_of_choice.length > 0" class="mt-3 flex flex-wrap gap-2">
                                <div
                                    v-for="schoolId in form.schools_of_choice"
                                    :key="schoolId"
                                    class="px-3 py-1 bg-primary/10 border border-primary/30 rounded-full text-sm flex items-center gap-2"
                                >
                                    {{ getSchoolName(schoolId) }}
                                    <button
                                        type="button"
                                        @click="removeSchool(schoolId)"
                                        class="text-primary hover:text-primary/70"
                                    >
                                        ✕
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Country Preferences multi-select with search -->
                        <div class="space-y-2">
                            <label for="country_search"
                                   class="text-sm font-medium">Country Preferences *</label>
                            <div class="relative z-20">
                                <input
                                    id="country_search"
                                    v-model="countrySearch"
                                    type="text"
                                    placeholder="Search and select countries..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleCountryFocus"
                                    @blur="handleCountryBlur"
                                />
                                <!-- Added z-50 and proper positioning to prevent overlap -->
                                <div v-if="showCountryDropdown" class="absolute z-50 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredCountries.length === 0" class="p-3 text-sm text-muted-foreground">
                                        No countries found
                                    </div>
                                    <div
                                        v-for="country in filteredCountries"
                                        :key="country.id"
                                        @click="toggleCountry(country.id)"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors flex items-center"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="form.country_of_preference.includes(country.id)"
                                            class="mr-2"
                                            @change="toggleCountry(country.id)"
                                        />
                                        {{ country.name }}
                                    </div>
                                </div>
                            </div>
                            <!-- Display selected countries -->
                            <div v-if="form.country_of_preference.length > 0" class="mt-3 flex flex-wrap gap-2">
                                <div
                                    v-for="countryId in form.country_of_preference"
                                    :key="countryId"
                                    class="px-3 py-1 bg-primary/10 border border-primary/30 rounded-full text-sm flex items-center gap-2"
                                >
                                    {{ getCountryName(countryId) }}
                                    <button
                                        type="button"
                                        @click="removeCountry(countryId)"
                                        class="text-primary hover:text-primary/70"
                                    >
                                        ✕
                                    </button>
                                </div>
                            </div>
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

                        <!-- Improved file upload with better validation and UX -->
                        <div class="space-y-2">
                            <label for="documents" class="text-sm font-medium">Application Documents</label>
                            <div
                                class="border-2 border-dashed border-border rounded-lg p-8 text-center hover:border-primary transition-all duration-300 cursor-pointer"
                                :class="{ 'bg-primary/5 border-primary': isDragOver }"
                                @click="$refs.documentInput.click()"
                                @drop.prevent="handleDrop"
                                @dragover.prevent="isDragOver = true"
                                @dragleave.prevent="isDragOver = false"
                            >
                                <svg class="w-12 h-12 mx-auto text-muted-foreground mb-4" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-muted-foreground mb-2">Click to upload or drag and drop</p>
                                <p class="text-xs text-muted-foreground">PDF, DOC, DOCX (max. 10MB each)</p>
                            </div>
                            <div v-if="form.application_documents.length > 0" class="mt-4">
                                <p class="text-sm font-medium mb-2">Uploaded Files:</p>
                                <ul class="space-y-2">
                                    <li v-for="(file, index) in form.application_documents" :key="index" class="text-sm text-muted-foreground flex items-center justify-between bg-muted/50 p-3 rounded border border-border">
                                        <div class="flex items-center gap-2 flex-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-foreground">{{ file.name }}</div>
                                                <div class="text-xs">{{ (file.size / 1024).toFixed(2) }} KB</div>
                                            </div>
                                        </div>
                                        <button
                                            type="button"
                                            @click="removeFile(index)"
                                            class="text-destructive hover:text-destructive/70 text-xs font-medium ml-2"
                                        >
                                            Remove
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <input
                                ref="documentInput"
                                type="file"
                                multiple
                                accept=".pdf,.doc,.docx"
                                class="hidden"
                                @change="handleFileUpload"
                            />
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
import {ref, onMounted, computed, watch} from 'vue';
import {useRouter} from 'vue-router';
import {useTheme} from '../composables/useTheme';
import {applicationsAPI, coursesAPI, countriesAPI, schoolsAPI} from '../services/api';

export default {
    name: 'CreateApplication',
    components: {},
    setup() {
        const router = useRouter();
        const {isDark, toggleTheme} = useTheme();

        const loading = ref(false);
        const error = ref(null);
        const success = ref(false);
        const successMessage = ref('Application submitted successfully!');
        const isDragOver = ref(false);
        const courses = ref([]);
        const schools = ref([]);
        const countries = ref([]);

        const courseSearch = ref('');
        const schoolSearch = ref('');
        const countrySearch = ref('');
        const showCourseDropdown = ref(false);
        const showSchoolDropdown = ref(false);
        const showCountryDropdown = ref(false);

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
            schools_of_choice: [],
            country_of_preference: [],
            additional_notes: '',
            application_documents: []
        });

        const filteredCourses = computed(() => {
            const courseList = Array.isArray(courses.value) ? courses.value : [];
            if (!courseSearch.value) return courseList;
            return courseList.filter(course =>
                course.name.toLowerCase().includes(courseSearch.value.toLowerCase())
            );
        });

        const filteredSchools = computed(() => {
            const schoolList = Array.isArray(schools.value) ? schools.value : [];
            if (!schoolSearch.value) return schoolList;
            return schoolList.filter(school =>
                school.name.toLowerCase().includes(schoolSearch.value.toLowerCase())
            );
        });

        const filteredCountries = computed(() => {
            const countryList = Array.isArray(countries.value) ? countries.value : [];
            if (!countrySearch.value) return countryList;
            return countryList.filter(country =>
                country.name.toLowerCase().includes(countrySearch.value.toLowerCase())
            );
        });

        const fetchCourses = async () => {
            try {
                const response = await coursesAPI.getAll();
                const data = response.data?.data?.data || [];
                courses.value = Array.isArray(data) ? data : [];
            } catch (err) {
                console.error('[v0] Error fetching courses:', err);
                courses.value = [];
            }
        };

        const fetchSchools = async () => {
            try {
                const response = await schoolsAPI.getAll();
                const data = response.data?.data?.data || [];
                schools.value = Array.isArray(data) ? data : [];
            } catch (err) {
                console.error('[v0] Error fetching schools:', err);
                schools.value = [];
            }
        };

        const fetchCountries = async () => {
            try {
                const response = await countriesAPI.getAll();
                const data = response.data?.data?.data || [];
                countries.value = Array.isArray(data) ? data : [];
            } catch (err) {
                console.error('[v0] Error fetching countries:', err);
                countries.value = [];
            }
        };

        const handleCourseFocus = () => {
            showCourseDropdown.value = true;
            courseSearch.value = '';
            if (courses.value.length === 0) {
                fetchCourses();
            }
        };

        const handleSchoolFocus = () => {
            showSchoolDropdown.value = true;
            schoolSearch.value = '';
            if (schools.value.length === 0) {
                fetchSchools();
            }
        };

        const handleCountryFocus = () => {
            showCountryDropdown.value = true;
            countrySearch.value = '';
            if (countries.value.length === 0) {
                fetchCountries();
            }
        };

        let courseTimeout;
        watch(courseSearch, async (newVal) => {
            clearTimeout(courseTimeout);
            if (newVal) {
                courseTimeout = setTimeout(async () => {
                    try {
                        const response = await coursesAPI.search(newVal, 20);
                        const data = response.data?.data?.data || [];
                        courses.value = Array.isArray(data) ? data : [];
                    } catch (err) {
                        console.error('[v0] Error searching courses:', err);
                        courses.value = [];
                    }
                }, 300);
            }
        });

        let schoolTimeout;
        watch(schoolSearch, async (newVal) => {
            clearTimeout(schoolTimeout);
            if (newVal) {
                schoolTimeout = setTimeout(async () => {
                    try {
                        const response = await schoolsAPI.search(newVal, 20);
                        const data = response.data?.data?.data || [];
                        schools.value = Array.isArray(data) ? data : [];
                    } catch (err) {
                        console.error('[v0] Error searching schools:', err);
                        schools.value = [];
                    }
                }, 300);
            }
        });

        let countryTimeout;
        watch(countrySearch, async (newVal) => {
            clearTimeout(countryTimeout);
            if (newVal) {
                countryTimeout = setTimeout(async () => {
                    try {
                        const response = await countriesAPI.search(newVal, 20);
                        const data = response.data?.data?.data || [];
                        countries.value = Array.isArray(data) ? data : [];
                    } catch (err) {
                        console.error('[v0] Error searching countries:', err);
                        countries.value = [];
                    }
                }, 300);
            }
        });

        const toggleSchool = (schoolId) => {
            const index = form.value.schools_of_choice.indexOf(schoolId);
            if (index > -1) {
                form.value.schools_of_choice.splice(index, 1);
            } else {
                form.value.schools_of_choice.push(schoolId);
            }
        };

        const removeSchool = (schoolId) => {
            form.value.schools_of_choice = form.value.schools_of_choice.filter(id => id !== schoolId);
        };

        const toggleCountry = (countryId) => {
            const index = form.value.country_of_preference.indexOf(countryId);
            if (index > -1) {
                form.value.country_of_preference.splice(index, 1);
            } else {
                form.value.country_of_preference.push(countryId);
            }
        };

        const removeCountry = (countryId) => {
            form.value.country_of_preference = form.value.country_of_preference.filter(id => id !== countryId);
        };

        const getCourseName = (courseId) => {
            return courses.value.find(c => c.id === courseId)?.name || '';
        };

        const getSchoolName = (schoolId) => {
            return schools.value.find(s => s.id === schoolId)?.name || '';
        };

        const getCountryName = (countryId) => {
            return countries.value.find(c => c.id === countryId)?.name || '';
        };

        const handleFileUpload = (event) => {
            const files = Array.from(event.target.files);
            const validFiles = [];
            const errors = [];

            files.forEach(file => {
                const maxSize = 10 * 1024 * 1024; // 10MB
                if (file.size > maxSize) {
                    errors.push(`${file.name} exceeds 10MB limit`);
                } else if (!['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type)) {
                    errors.push(`${file.name} is not a valid format (PDF, DOC, DOCX only)`);
                } else {
                    validFiles.push(file);
                }
            });

            if (errors.length > 0) {
                error.value = errors.join('; ');
                setTimeout(() => error.value = null, 5000);
            }

            form.value.application_documents.push(...validFiles);
            event.target.value = '';
        };

        const handleDrop = (event) => {
            isDragOver.value = false;
            handleFileUpload({target: {files: event.dataTransfer.files}});
        };

        const removeFile = (index) => {
            form.value.application_documents.splice(index, 1);
        };

        const handleSubmit = async () => {
            try {
                loading.value = true;
                error.value = null;
                success.value = false;

                const applicationData = {
                    ...form.value
                };

                const response = await applicationsAPI.create(applicationData);

                successMessage.value = response.data?.message || 'Application submitted successfully!';
                success.value = true;

                setTimeout(() => {
                    router.push('/students');
                }, 2000);
            } catch (err) {
                console.error('[v0] Error submitting application:', err);
                error.value = err.response?.data?.message || 'Failed to submit application';
            } finally {
                loading.value = false;
            }
        };

        const handleCourseBlur = () => {
            setTimeout(() => {
                showCourseDropdown.value = false;
            }, 200);
        };

        const handleSchoolBlur = () => {
            setTimeout(() => {
                showSchoolDropdown.value = false;
            }, 200);
        };

        const handleCountryBlur = () => {
            setTimeout(() => {
                showCountryDropdown.value = false;
            }, 200);
        };

        onMounted(() => {
            fetchCourses();
            fetchSchools();
            fetchCountries();
        });

        return {
            form,
            courses,
            schools,
            countries,
            loading,
            error,
            success,
            successMessage,
            isDragOver,
            courseSearch,
            schoolSearch,
            countrySearch,
            showCourseDropdown,
            showSchoolDropdown,
            showCountryDropdown,
            filteredCourses,
            filteredSchools,
            filteredCountries,
            toggleSchool,
            removeSchool,
            toggleCountry,
            removeCountry,
            getCourseName,
            getSchoolName,
            getCountryName,
            handleFileUpload,
            handleDrop,
            removeFile,
            handleSubmit,
            isDark,
            toggleTheme,
            handleCourseBlur,
            handleSchoolBlur,
            handleCountryBlur,
            handleCourseFocus,
            handleSchoolFocus,
            handleCountryFocus
        };
    }
};
</script>
