<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8">
            <div class="mb-8 animate-slide-up">
                <h1 class="text-3xl font-bold mb-2">Agent List</h1>
                <p class="text-muted-foreground">Manage and track all Agent details</p>
            </div>

            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center gap-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                    <p class="text-muted-foreground">Loading Agents...</p>
                </div>
            </div>

            <div v-else-if="error"
                 class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm mb-6">
                {{ error }}
                <button @click="fetchAgents" class="ml-4 underline hover:no-underline">Retry</button>
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
                                placeholder="Search by name, email, phone or agency name..."
                                class="w-full pl-10 pr-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            />
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="border-b border-border">
                            <th class="text-left py-4 px-4 text-sm font-semibold">Full Name</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Agency Name</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Email</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Phone Number</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">BRN</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Active Status</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Joined Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">BDM Officer</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Total Students</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Total Applications</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr
                            v-for="agent in filteredAgents"
                            :key="agent.id"
                            class="border-b border-border hover:bg-muted/95 transition-all duration-200"
                        >
                            <!-- Full Name -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.firstName }} {{ agent.lastName }}
                            </td>

                            <!-- Agency Name -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.agencyName || 'N/A' }}
                            </td>

                            <!-- Email -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.email }}
                            </td>

                            <!-- Phone -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.phone || 'N/A' }}
                            </td>

                            <!-- BRN -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.businessRegistrationNumber || 'N/A' }}
                            </td>

                            <!-- Active Status -->
                            <td class="py-4 px-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="agent.isActive ? 'bg-green-500/10 text-green-600'
                                      : 'bg-red-500/10 text-red-600'"
                                >
                                    {{ agent.isActive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <!-- Joined Date -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.createdAt }}
                            </td>

                            <!-- BDM Officer -->
                            <td class="py-4 px-4 text-sm">
                                {{ agent.bdmOfficer?.fullName?.trim() || 'N/A' }}
                            </td>

                            <!-- Total Students -->
                            <td class="py-4 px-4 text-sm text-center">
                                {{ agent.totalStudents }}
                            </td>

                            <!-- Total Applications -->
                            <td class="py-4 px-4 text-sm text-center">
                                {{ agent.totalApplications }}
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="filteredAgents.length === 0">
                            <td colspan="9" class="py-8 text-center text-muted-foreground text-sm">
                                No agents found
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="agents.length > 0" class="mt-6 space-y-4">
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

                <!--<div v-if="filteredAgents.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 00-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-muted-foreground">No Applications found matching your filters</p>
                </div>-->
            </div>
        </main>
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from 'vue';
import {agentsAPI} from "../services/api.js";

const loading = ref(true);
const error = ref(null);
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);
const agents = ref([]);

const pagination = ref({
    total: 0,
    from: 0,
    to: 0,
    currentPage: 1,
    perPage: 10,
    lastPage: 1
});

const fetchAgents = async () => {
    try {
        loading.value = true;
        error.value = null;

        const agentsRes = await agentsAPI.getAll(currentPage.value, itemsPerPage.value, searchQuery.value);
        const paginationData = agentsRes?.data || {data: [], meta: {}};
        const agentsData = paginationData.data || [];

        agents.value = agentsData.map(agent => ({
            id: agent.id,
            firstName: agent.first_name,
            lastName: agent.last_name,
            agencyName: agent.agency_name,
            email: agent.email,
            phone: agent.phone,
            businessRegistrationNumber: agent.business_registration_number,
            isActive: agent.is_active,
            createdAt: agent.created_at ? new Date(agent.created_at).toLocaleDateString() : 'N/A',
            bdmOfficer: {
                id: agent.bdm_officer_details.id,
                fullName: agent.bdm_officer_details.full_name,
                email: agent.bdm_officer_details.email,
                phone: agent.bdm_officer_details.phone
            },
            totalStudents: agent.total_students,
            totalApplications: agent.total_applications
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
        console.error('Error fetching agents:', err);
        error.value = 'Failed to load agents. Please try again.';
    } finally {
        loading.value = false;
    }
};

const filteredAgents = computed(() => {
    return agents.value;
});

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
        await fetchAgents();
    }
};

let searchTimeout = null;
watch(searchQuery, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentPage.value = 1;
        fetchAgents();
    }, 300);
});

watch(itemsPerPage, async () => {
    currentPage.value = 1;
    await fetchAgents();
});

onMounted(() => {
    fetchAgents();
});
</script>
