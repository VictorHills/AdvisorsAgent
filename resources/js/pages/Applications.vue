<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8">
            <div class="mb-8 animate-slide-up">
                <h1 class="text-3xl font-bold mb-2">Student Applications</h1>
                <p class="text-muted-foreground">Manage and track all student applications</p>
            </div>

            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center gap-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                    <p class="text-muted-foreground">Loading Student Applications...</p>
                </div>
            </div>

            <div v-else-if="error"
                 class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm mb-6">
                {{ error }}
                <button @click="fetchApplications" class="ml-4 underline hover:no-underline">Retry</button>
            </div>

            <div v-else class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div
                        class="flex-1 flex flex-col md:flex-row items-stretch md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1 relative">
                            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search by name, email, or course..."
                                class="w-full pl-10 pr-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            />
                        </div>
                        <select
                            v-model="selectedCountry"
                            class="px-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                            <option value="">All Countries</option>
                            <option v-for="country in uniqueCountries" :key="country" :value="country">
                                {{ country }}
                            </option>
                        </select>
                    </div>

                    <router-link
                        v-if="!isCounselor"
                        to="/students/create"
                        class="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg hover:scale-105 flex items-center space-x-2 justify-center md:justify-start"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add Student</span>
                    </router-link>

                    <router-link
                        v-if="!isCounselor"
                        to="/applications/create"
                        class="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg hover:scale-105 flex items-center space-x-2 justify-center md:justify-start"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>New Application</span>
                    </router-link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                    <div v-for="(stat, index) in stats" :key="index"
                         class="p-4 bg-muted/50 rounded-lg border border-border hover:border-primary/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 cursor-pointer">
                        <div class="text-2xl font-bold mb-1">{{ stat.value }}</div>
                        <div class="text-sm text-muted-foreground">{{ stat.label }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="border-b border-border">
                            <th class="text-left py-4 px-4 text-sm font-semibold">Full Name</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Course</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Class of Degree</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Universities</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Countries</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Applied Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="application in filteredApplications" :key="application.id"
                            class="border-b border-border hover:bg-muted/95 transition-all duration-200">
                            <td class="py-4 px-4 text-sm">{{ application.studentName }}</td>
                            <td class="py-4 px-4 text-sm">{{ application.courseName }}</td>
                            <td class="py-4 px-4 text-sm">
                                <span :class="getStatusClass(application.status)">
                                    {{ application.status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm">{{ application.classOfDegree }}</td>
                            <td class="py-4 px-4 text-sm">
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="(uni, idx) in getDisplayedUniversities(application.schools, 2)"
                                          :key="idx"
                                          class="inline-block bg-secondary text-secondary-foreground text-xs px-2 py-1 rounded">
                                        {{ uni }}
                                    </span>
                                    <span v-if="application.schools.length > 2"
                                          class="inline-block bg-muted text-muted-foreground text-xs px-2 py-1 rounded">
                                        +{{ application.schools.length - 2 }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm">
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="(country, idx) in getDisplayedCountries(application.countries, 2)"
                                          :key="idx"
                                          class="inline-block bg-secondary text-secondary-foreground text-xs px-2 py-1 rounded">
                                        {{ country }}
                                    </span>
                                    <span v-if="application.countries.length > 2"
                                          class="inline-block bg-muted text-muted-foreground text-xs px-2 py-1 rounded">
                                        +{{ application.countries.length - 2 }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm">{{ application.submittedAt }}</td>
                            <td class="py-4 px-4 text-sm">
                                <router-link class="text-primary hover:underline">View</router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="applications.length > 0" class="mt-6 space-y-4">
                    <!-- Items per page selector -->
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-3">
                            <label for="itemsPerPage" class="text-sm text-muted-foreground">Items per page:</label>
                            <select v-model.number="itemsPerPage" id="itemsPerPage"
                                    class="px-3 py-2 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="text-sm text-muted-foreground">
                            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex items-center justify-center gap-2">
                            <button
                                @click="updatePage(Math.max(1, currentPage - 1))"
                                :disabled="currentPage === 1"
                                class="px-3 py-2 border border-border rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-muted transition-all"
                            >
                                Previous
                            </button>
                            <div class="flex items-center gap-1">
                                <button
                                    v-for="page in paginationButtons"
                                    :key="page"
                                    @click="updatePage(page)"
                                    :class="currentPage === page ? 'bg-primary text-primary-foreground' : 'border border-border hover:bg-muted'"
                                    class="px-3 py-2 rounded-lg transition-all"
                                >
                                    {{ page }}
                                </button>
                            </div>
                            <button
                                @click="updatePage(Math.min(pagination.lastPage, currentPage + 1))"
                                :disabled="currentPage === pagination.lastPage"
                                class="px-3 py-2 border border-border rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-muted transition-all"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="filteredApplications.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 00-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-muted-foreground">No Applications found matching your filters</p>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import {ref, computed, onMounted, watch} from 'vue';
import {useAuth} from "../composables/useAuth.js";
import {applicationsAPI, dashboardAPI} from "../services/api.js";

const {isCounselor} = useAuth();
const loading = ref(true);
const error = ref(null);
const applications = ref([]);
const stats = ref([]);
const searchQuery = ref('');
const selectedCountry = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);

const pagination = ref({
    total: 0,
    from: 0,
    to: 0,
    currentPage: 1,
    perPage: 10,
    lastPage: 1
});

const fetchStats = async () => {
    try {
        const statsPromise = isCounselor.value
            ? dashboardAPI.getCounselorStats()
            : dashboardAPI.getStats()

        const [statsRes] = await Promise.all([
            statsPromise.catch(() => ({data: {data: {}}})),
        ])

        const statsData = statsRes.data.data || response.data;

        stats.value = [
            {value: statsData.total_students || 0, label: 'Total Students'},
            {value: statsData.total_applications || 0, label: 'Total Applications'},
            {value: statsData.visa_application_granted || 0, label: 'Visa Granted'},
            {value: statsData.cas_ceo_loa_i20_stage || 0, label: 'CAS/CEO/LOA/I20 Stage'},
            {value: statsData.unconditional_offers_received || 0, label: 'Unconditional Offers'},
            {value: statsData.application_rejected || 0, label: 'Applications Rejected'},
        ];

    } catch (err) {
        console.error('[v0] Error fetching stats:', err);
    }
};

const uniqueCountries = computed(() => {
    const countries = new Set();
    applications.value.forEach(app => {
        app.countries.forEach(country => countries.add(country));
    });
    return Array.from(countries).sort();
});

const filteredApplications = computed(() => {
    return applications.value.filter(app => {
        const matchesSearch = searchQuery.value === '' ||
            app.studentName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            app.courseName.toLowerCase().includes(searchQuery.value.toLowerCase());

        const matchesCountry = selectedCountry.value === '' ||
            app.countries.includes(selectedCountry.value);

        return matchesSearch && matchesCountry;
    });
});

const getDisplayedUniversities = (schools, limit) => schools.slice(0, limit);
const getDisplayedCountries = (countries, limit) => countries.slice(0, limit);

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

const fetchApplications = async () => {
    try {
        loading.value = true;
        error.value = null;

        const applicationPromise = isCounselor.value
            ? applicationsAPI.getCounselorApplications(currentPage.value, itemsPerPage.value)
            : applicationsAPI.getAll(currentPage.value, itemsPerPage.value);

        const [applicationRes] = await Promise.all([
            applicationPromise.catch(() => ({data: []})),
        ]);

        const paginationData = applicationRes.data;
        const applicationsData = paginationData.data || [];

        applications.value = applicationsData.map(application => ({
            id: application.id,
            courseName: application.course.name.trim(),
            studentName: `${application.student.first_name} ${application.student.middle_name} ${application.student.last_name}`,
            status: application.status,
            submittedAt: application.created_at ? new Date(application.created_at).toLocaleDateString() : 'N/A',
            classOfDegree: application.class_of_degree || 'N/A',
            schools: application.schools_of_choice_details?.map(s => s.name) || [],
            countries: application.country_of_preference_details?.map(c => c.name) || [],
        }));

        if (paginationData.meta) {
            pagination.value = {
                total: paginationData.meta.total,
                from: paginationData.meta.from,
                to: paginationData.meta.to,
                currentPage: paginationData.meta.current_page,
                perPage: paginationData.meta.per_page,
                lastPage: paginationData.meta.last_page
            };
        }

    } catch (err) {
        console.error('Error fetching students:', err);
        error.value = 'Failed to load applications. Please try again.';
    } finally {
        loading.value = false;
    }
};

const paginationButtons = computed(() => {
    const buttons = [];
    const maxButtons = 5;
    let start = Math.max(1, currentPage.value - Math.floor(maxButtons / 2));
    let end = Math.min(pagination.value.lastPage, start + maxButtons - 1);

    if (end - start + 1 < maxButtons) {
        start = Math.max(1, end - maxButtons + 1);
    }

    for (let i = start; i <= end; i++) {
        buttons.push(i);
    }

    return buttons;
});

const updatePage = async (newPage) => {
    if (newPage >= 1 && newPage <= pagination.value.lastPage) {
        currentPage.value = newPage;
        await fetchApplications();
    }
};

watch(itemsPerPage, async () => {
    currentPage.value = 1;
    await fetchApplications();
});

onMounted(() => {
    fetchApplications();
    fetchStats();
});
</script>
