<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <Navigation />

        <main class="container mx-auto px-6 py-8">
            <div class="mb-8 animate-slide-up">
                <h1 class="text-3xl font-bold mb-2">Student Applications</h1>
                <p class="text-muted-foreground">Manage and track all student applications</p>
            </div>

            <div class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div class="flex-1 flex items-center space-x-4">
                        <div class="flex-1 relative">
                            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search by name, email, or course..."
                                class="w-full pl-10 pr-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            />
                        </div>
                        <select v-model="statusFilter" class="px-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="In Review">In Review</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        <select v-model="countryFilter" class="px-4 py-2.5 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>New Application</span>
                    </router-link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div v-for="(stat, index) in stats" :key="index" class="p-4 bg-muted/50 rounded-lg border border-border hover:border-primary/50 transition-all duration-200">
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
                                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
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
                                    <button class="p-2 hover:bg-muted rounded-lg transition-all duration-200 hover:scale-110" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button class="p-2 hover:bg-muted rounded-lg transition-all duration-200 hover:scale-110" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="filteredStudents.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-muted-foreground">No students found matching your filters</p>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { ref, computed } from 'vue';
import Navigation from '../components/Navigation.vue';

export default {
    name: 'Students',
    components: {
        Navigation
    },
    setup() {
        const searchQuery = ref('');
        const statusFilter = ref('');
        const countryFilter = ref('');

        const stats = [
            { value: 248, label: 'Total Applications' },
            { value: 186, label: 'Approved' },
            { value: 42, label: 'Pending' },
            { value: 20, label: 'In Review' }
        ];

        const students = ref([
            {
                id: 1,
                name: 'Sarah Johnson',
                email: 'sarah.j@email.com',
                initials: 'SJ',
                course: 'Computer Science',
                degree: 'Bachelor',
                country: 'United Kingdom',
                phone: '+44 20 1234 5678',
                status: 'Approved',
                statusClass: 'bg-emerald-500/20 text-emerald-500',
                date: '2024-01-15'
            },
            {
                id: 2,
                name: 'Michael Chen',
                email: 'michael.c@email.com',
                initials: 'MC',
                course: 'Business Administration',
                degree: 'Master',
                country: 'Canada',
                phone: '+1 416 555 0123',
                status: 'In Review',
                statusClass: 'bg-amber-500/20 text-amber-500',
                date: '2024-01-14'
            },
            {
                id: 3,
                name: 'Emma Williams',
                email: 'emma.w@email.com',
                initials: 'EW',
                course: 'Engineering',
                degree: 'Bachelor',
                country: 'Australia',
                phone: '+61 2 9876 5432',
                status: 'Pending',
                statusClass: 'bg-blue-500/20 text-blue-500',
                date: '2024-01-12'
            },
            {
                id: 4,
                name: 'David Brown',
                email: 'david.b@email.com',
                initials: 'DB',
                course: 'Medicine',
                degree: 'Bachelor',
                country: 'United States',
                phone: '+1 212 555 0199',
                status: 'Approved',
                statusClass: 'bg-emerald-500/20 text-emerald-500',
                date: '2024-01-10'
            },
            {
                id: 5,
                name: 'Lisa Anderson',
                email: 'lisa.a@email.com',
                initials: 'LA',
                course: 'Law',
                degree: 'Master',
                country: 'United Kingdom',
                phone: '+44 20 9876 5432',
                status: 'In Review',
                statusClass: 'bg-amber-500/20 text-amber-500',
                date: '2024-01-09'
            },
            {
                id: 6,
                name: 'James Wilson',
                email: 'james.w@email.com',
                initials: 'JW',
                course: 'Data Science',
                degree: 'Master',
                country: 'Canada',
                phone: '+1 604 555 0177',
                status: 'Approved',
                statusClass: 'bg-emerald-500/20 text-emerald-500',
                date: '2024-01-08'
            },
            {
                id: 7,
                name: 'Sophie Martin',
                email: 'sophie.m@email.com',
                initials: 'SM',
                course: 'Psychology',
                degree: 'Bachelor',
                country: 'Australia',
                phone: '+61 3 8765 4321',
                status: 'Pending',
                statusClass: 'bg-blue-500/20 text-blue-500',
                date: '2024-01-07'
            },
            {
                id: 8,
                name: 'Robert Taylor',
                email: 'robert.t@email.com',
                initials: 'RT',
                course: 'Architecture',
                degree: 'Bachelor',
                country: 'United States',
                phone: '+1 310 555 0144',
                status: 'Rejected',
                statusClass: 'bg-red-500/20 text-red-500',
                date: '2024-01-06'
            }
        ]);

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

        return {
            searchQuery,
            statusFilter,
            countryFilter,
            stats,
            students,
            filteredStudents
        };
    }
};
</script>
