<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8">
            <div class="mb-8 animate-slide-up">
                <div class="flex items-center gap-4 mb-4">
                    <router-link to="/applications" class="text-primary hover:underline flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to Applications
                    </router-link>
                </div>
                <h1 class="text-3xl font-bold mb-2">Application Details</h1>
                <p class="text-muted-foreground">View application information</p>
            </div>

            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center gap-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                    <p class="text-muted-foreground">Loading Application...</p>
                </div>
            </div>

            <div v-else-if="error"
                 class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm mb-6">
                {{ error }}
            </div>

            <div v-else class="glass-card rounded-xl p-6 animate-slide-up">
                <!-- Student Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Student Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-sm text-muted-foreground">Full Name</label>
                            <p class="font-medium">{{ application.studentName }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-muted-foreground">Phone Number</label>
                            <p class="font-medium">{{ application.studentPhone }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-muted-foreground">Email</label>
                            <p class="font-medium">{{ application.studentEmail }}</p>
                        </div>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Application Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-muted-foreground">Course</label>
                            <p class="font-medium">{{ application.courseName }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-muted-foreground">Class of Degree</label>
                            <p class="font-medium">{{ application.classOfDegree }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-muted-foreground">Status</label>
                            <div>
                                <span :class="getStatusClass(application.status)">
                                    {{ application.status }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm text-muted-foreground">Applied Date</label>
                            <p class="font-medium">{{ application.submittedAt }}</p>
                        </div>
                    </div>
                </div>

                <!-- Schools of Choice -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Schools of Choice
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="(school, idx) in application.schools" :key="idx"
                              class="inline-block bg-secondary text-secondary-foreground px-3 py-2 rounded-lg">
                            {{ school }}
                        </span>
                        <span v-if="application.schools.length === 0"
                              class="text-muted-foreground">No schools selected</span>
                    </div>
                </div>

                <!-- Countries of Preference -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Countries of Preference
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="(country, idx) in application.countries" :key="idx"
                              class="inline-block bg-secondary text-secondary-foreground px-3 py-2 rounded-lg">
                            {{ country }}
                        </span>
                        <span v-if="application.countries.length === 0" class="text-muted-foreground">No countries selected</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-end">
                    <router-link
                        v-if="isCounselor"
                        :to="`/applications/${applicationId}/edit`"
                        class="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg hover:scale-105">
                        Edit Application
                    </router-link>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import {useRoute} from 'vue-router';
import {applicationsAPI} from '../services/api.js';
import {useAuth} from "../composables/useAuth.js";

const route = useRoute();
const applicationId = route.params.id;
const loading = ref(true);
const error = ref(null);
const application = ref({});
const {isCounselor} = useAuth();

const getStatusClass = (status) => {
    const baseClass = 'px-3 py-1 rounded-full text-xs font-medium';
    const statusClasses = {
        'Pending': 'bg-yellow-500/20 text-yellow-700',
        'Approved': 'bg-green-500/20 text-green-700',
        'Rejected': 'bg-red-500/20 text-red-700',
        'In Review': 'bg-blue-500/20 text-blue-700',
        'Submitted': 'bg-purple-500/20 text-purple-700',
    };
    return `${baseClass} ${statusClasses[status] || 'bg-gray-500/20 text-gray-700'}`;
};

const fetchApplication = async () => {
    try {
        loading.value = true;
        error.value = null;

        const viewApplicationPromise = isCounselor.value
            ? applicationsAPI.getCounselorApplicationById(applicationId)
            : applicationsAPI.getOne(applicationId);

        const [viewApplicationRes] = await Promise.all([
            viewApplicationPromise.catch(() => ({data: []})),
        ]);

        const app = viewApplicationRes.data.data || viewApplicationRes.data;

        application.value = {
            id: app.id,
            courseName: app.course?.name || 'N/A',
            studentName: `${app.student?.first_name || ''} ${app.student?.middle_name || ''} ${app.student?.last_name || ''}`.trim(),
            studentEmail: app.student?.email || 'N/A',
            studentPhone: app.student?.phone_number || 'N/A',
            status: app.status,
            submittedAt: app.created_at ? new Date(app.created_at).toLocaleDateString() : 'N/A',
            classOfDegree: app.class_of_degree || 'N/A',
            schools: app.schools_of_choice_details?.map(s => s.name) || [],
            countries: app.country_of_preference_details?.map(c => c.name) || [],
        };
    } catch (err) {
        console.error('Error fetching application:', err);
        error.value = 'Failed to load application. Please try again.';
    } finally {
        loading.value = false;
    }

};

onMounted(() => {
    fetchApplication();
});
</script>
