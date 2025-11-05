<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8">
            <div class="mb-8 animate-slide-up">
                <h1 class="text-3xl font-bold mb-2">Student Applications</h1>
                <p class="text-muted-foreground">Manage and track all student applications</p>
            </div>

            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
            </div>

            <!-- Added error state to show if data fails to load -->
            <div v-else-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm mb-6">
                {{ error }}
                <button @click="fetchStudents" class="ml-4 underline hover:no-underline">Retry</button>
            </div>

            <div v-else class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div class="flex-1 flex items-center space-x-4">
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
                        <select v-model="statusFilter"
                                class="px-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="In Review">In Review</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        <select v-model="countryFilter"
                                class="px-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                            <option value="">All Countries</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="United States">United States</option>
                        </select>
                    </div>
                    <router-link
                        to="/applications/create"
                        class="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg hover:scale-105 flex items-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>New Application</span>
                    </router-link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div v-for="(stat, index) in stats" :key="index"
                         class="p-4 bg-muted/50 rounded-lg border border-border hover:border-primary/50 transition-all duration-200">
                        <div class="text-2xl font-bold mb-1">{{ stat.value }}</div>
                        <div class="text-sm text-muted-foreground">{{ stat.label }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="border-b border-border">
                            <th class="text-left py-4 px-4 text-sm font-semibold">Student</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Course</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Country</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Phone</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Applied</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="student in filteredStudents"
                            :key="student.id"
                            class="border-b border-border hover:bg-muted/50 transition-all duration-200"
                        >
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-primary text-sm font-medium">{{ student.initials }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ student.name }}</div>
                                        <div class="text-sm text-muted-foreground">{{ student.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm font-medium">{{ student.course }}</div>
                                <div class="text-xs text-muted-foreground">{{ student.degree }}</div>
                            </td>
                            <td class="py-4 px-4 text-sm">{{ student.country }}</td>
                            <td class="py-4 px-4 text-sm text-muted-foreground">{{ student.phone }}</td>
                            <td class="py-4 px-4">
                                    <span
                                        :class="student.statusClass"
                                        class="px-3 py-1 rounded-full text-xs font-medium transition-all duration-200"
                                    >
                                        {{ student.status }}
                                    </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-muted-foreground">{{ student.date }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-2">
                                    <!-- View details icon (info icon) -->
                                    <button
                                        @click="viewDetails(student.id)"
                                        class="p-2 hover:bg-muted rounded-lg transition-all duration-200 hover:scale-110 text-muted-foreground hover:text-primary"
                                        title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                    <!-- Edit icon (pencil icon) now opens full edit form -->
                                    <button
                                        @click="editStudent(student.id)"
                                        class="p-2 hover:bg-muted rounded-lg transition-all duration-200 hover:scale-110 text-muted-foreground hover:text-primary"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="filteredStudents.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 00-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-muted-foreground">No students found matching your filters</p>
                </div>
            </div>

            <!-- Added View Details Modal -->
            <div v-if="showDetailsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                <div class="bg-card rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto border border-border">
                    <div class="sticky top-0 bg-card border-b border-border p-6 flex items-center justify-between">
                        <h2 class="text-xl font-bold">Application Details</h2>
                        <button @click="showDetailsModal = false" class="text-muted-foreground hover:text-foreground">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div v-if="selectedStudent" class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-muted-foreground">First Name</p>
                                <p class="font-medium">{{ selectedStudent.first_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Last Name</p>
                                <p class="font-medium">{{ selectedStudent.last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Email</p>
                                <p class="font-medium">{{ selectedStudent.email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Phone</p>
                                <p class="font-medium">{{ selectedStudent.phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Country</p>
                                <p class="font-medium">{{ selectedStudent.country }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground">Status</p>
                                <p class="font-medium">{{ selectedStudent.status }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-muted-foreground">Course</p>
                                <p class="font-medium">{{ selectedStudent.course?.name || 'N/A' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-muted-foreground">Additional Notes</p>
                                <p class="font-medium">{{ selectedStudent.additional_notes || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replaced basic edit modal with full application form that mirrors CreateApplication -->
            <div v-if="showEditModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto">
                <div class="bg-card rounded-lg w-full max-w-4xl border border-border my-8">
                    <div class="sticky top-0 bg-card border-b border-border p-6 flex items-center justify-between">
                        <h2 class="text-xl font-bold">Edit Student Application</h2>
                        <button @click="showEditModal = false" class="text-muted-foreground hover:text-foreground">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                        <!-- Personal Information Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">First Name</label>
                                    <input v-model="editForm.first_name" type="text" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Middle Name</label>
                                    <input v-model="editForm.middle_name" type="text" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Last Name</label>
                                    <input v-model="editForm.last_name" type="text" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Gender</label>
                                    <select v-model="editForm.gender" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Email</label>
                                    <input v-model="editForm.email" type="email" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Phone Number</label>
                                    <input v-model="editForm.phone_number" type="tel" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Country of Origin</label>
                                    <input v-model="editForm.country" type="text" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Class of Degree</label>
                                    <select v-model="editForm.class_of_degree" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
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

                        <!-- Academic Preferences Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold">Academic Preferences</h3>
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Desired Course</label>
                                <input v-model="editForm.course_id" type="text" placeholder="Course selection" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold">Additional Information</h3>
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Status</label>
                                <select v-model="editForm.status" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="In Review">In Review</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Additional Notes</label>
                                <textarea v-model="editForm.additional_notes" rows="4" class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                            <button @click="showEditModal = false" class="px-6 py-3 border border-border rounded-lg hover:bg-muted transition-all">Cancel</button>
                            <button @click="saveEdit" :disabled="editLoading" class="px-6 py-3 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">
                                {{ editLoading ? 'Saving...' : 'Save Changes' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import {ref, computed, onMounted} from 'vue';
import {studentsAPI, applicationsAPI} from '../services/api';

export default {
    name: 'Students',
    components: {},
    setup() {
        const searchQuery = ref('');
        const statusFilter = ref('');
        const countryFilter = ref('');

        const loading = ref(true);
        const error = ref(null);
        const students = ref([]);
        const selectedStudent = ref(null);
        const showDetailsModal = ref(false);
        const showEditModal = ref(false);
        const editLoading = ref(false);

        const editForm = ref({
            first_name: '',
            middle_name: '',
            last_name: '',
            gender: '',
            email: '',
            phone_number: '',
            country: '',
            class_of_degree: '',
            course_id: '',
            status: '',
            additional_notes: ''
        });

        const stats = ref([
            {value: 0, label: 'Total Applications'},
            {value: 0, label: 'Approved'},
            {value: 0, label: 'Pending'},
            {value: 0, label: 'In Review'}
        ]);

        const fetchStudents = async () => {
            try {
                loading.value = true;
                error.value = null;
                const response = await studentsAPI.getAll();

                const studentsData = Array.isArray(response.data) ? response.data : response.data.data || [];

                students.value = studentsData.map(student => ({
                    id: student.id,
                    name: `${student.first_name} ${student.last_name}`,
                    email: student.email,
                    initials: `${student.first_name[0]}${student.last_name[0]}`,
                    course: student.course?.name || 'N/A',
                    degree: student.class_of_degree || 'N/A',
                    country: student.country,
                    phone: student.phone_number,
                    status: student.status || 'Pending',
                    statusClass: getStatusClass(student.status || 'Pending'),
                    date: student.created_at ? new Date(student.created_at).toLocaleDateString() : 'N/A',
                    // Store full student data for modals
                    fullData: student
                }));

                const statusCounts = students.value.reduce((acc, student) => {
                    acc[student.status] = (acc[student.status] || 0) + 1;
                    return acc;
                }, {});

                stats.value = [
                    {value: students.value.length, label: 'Total Applications'},
                    {value: statusCounts['Approved'] || 0, label: 'Approved'},
                    {value: statusCounts['Pending'] || 0, label: 'Pending'},
                    {value: statusCounts['In Review'] || 0, label: 'In Review'}
                ];

            } catch (err) {
                console.error('[v0] Error fetching students:', err);
                error.value = 'Failed to load student data. Please try again.';
            } finally {
                loading.value = false;
            }
        };

        const getStatusClass = (status) => {
            const statusMap = {
                'Approved': 'bg-emerald-500/20 text-emerald-500',
                'Pending': 'bg-blue-500/20 text-blue-500',
                'In Review': 'bg-amber-500/20 text-amber-500',
                'Rejected': 'bg-red-500/20 text-red-500'
            };
            return statusMap[status] || 'bg-gray-500/20 text-gray-500';
        };

        const viewDetails = (studentId) => {
            const student = students.value.find(s => s.id === studentId);
            if (student) {
                selectedStudent.value = student.fullData;
                showDetailsModal.value = true;
            }
        };

        const editStudent = (studentId) => {
            const student = students.value.find(s => s.id === studentId);
            if (student) {
                selectedStudent.value = student.fullData;
                editForm.value = {
                    first_name: student.fullData.first_name || '',
                    middle_name: student.fullData.middle_name || '',
                    last_name: student.fullData.last_name || '',
                    gender: student.fullData.gender || '',
                    email: student.fullData.email || '',
                    phone_number: student.fullData.phone_number || '',
                    country: student.fullData.country || '',
                    class_of_degree: student.fullData.class_of_degree || '',
                    course_id: student.fullData.course_id || '',
                    status: student.fullData.status || 'Pending',
                    additional_notes: student.fullData.additional_notes || ''
                };
                showEditModal.value = true;
            }
        };

        const saveEdit = async () => {
            try {
                editLoading.value = true;
                await applicationsAPI.patch(selectedStudent.value.id, editForm.value);
                showEditModal.value = false;
                await fetchStudents();
            } catch (err) {
                console.error('[v0] Error updating student:', err);
                error.value = 'Failed to update student. Please try again.';
            } finally {
                editLoading.value = false;
            }
        };

        const filteredStudents = computed(() => {
            let filtered = students.value;

            if (searchQuery.value) {
                const query = searchQuery.value.toLowerCase();
                filtered = filtered.filter(student =>
                    student.name.toLowerCase().includes(query) ||
                    student.email.toLowerCase().includes(query) ||
                    student.course.toLowerCase().includes(query)
                );
            }

            if (statusFilter.value) {
                filtered = filtered.filter(student => student.status === statusFilter.value);
            }

            if (countryFilter.value) {
                filtered = filtered.filter(student => student.country === countryFilter.value);
            }

            return filtered;
        });

        onMounted(() => {
            fetchStudents();
        });

        return {
            loading,
            error,
            searchQuery,
            statusFilter,
            countryFilter,
            stats,
            students,
            filteredStudents,
            fetchStudents,
            viewDetails,
            editStudent,
            saveEdit,
            showDetailsModal,
            showEditModal,
            selectedStudent,
            editForm,
            editLoading
        };
    }
};
</script>
