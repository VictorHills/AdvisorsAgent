<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <Navigation />

        <main class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div v-for="(stat, index) in stats" :key="index" class="glass-card p-6 rounded-xl animate-slide-up hover:shadow-lg hover:border-primary transition-all duration-300 hover:-translate-y-1" :style="{ animationDelay: `${index * 0.1}s` }">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" :class="stat.bgColor">
                            <svg class="w-6 h-6" :class="stat.iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="stat.icon" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium" :class="stat.changeColor">{{ stat.change }}</span>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ stat.value }}</div>
                    <div class="text-sm text-muted-foreground">{{ stat.label }}</div>
                </div>
            </div>

            <div class="mb-8">
                <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary" style="animation-delay: 0.3s;">
                    <h3 class="font-bold mb-6">Monthly Applications Overview</h3>
                    <div class="h-80">
                        <BarChart :data="monthlyChartData" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary" style="animation-delay: 0.4s;">
                    <h3 class="font-bold mb-6">Applications Trend</h3>
                    <div class="h-64">
                        <LineChart :data="applicationsChartData" />
                    </div>
                </div>
                <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary" style="animation-delay: 0.5s;">
                    <h3 class="font-bold mb-6">Applications by Status</h3>
                    <div class="h-64">
                        <DoughnutChart :data="statusChartData" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 glass-card rounded-xl p-6 animate-slide-up border-t-2 border-primary">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Student Applications</h2>
                        <router-link
                            to="/applications/create"
                            class="px-4 py-2 bg-primary text-primary-foreground rounded-lg text-sm font-medium hover:bg-primary/90 transition-all duration-200"
                        >
                            + New Application
                        </router-link>
                    </div>

                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-1 relative">
                            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search students..."
                                class="w-full pl-10 pr-4 py-2 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            />
                        </div>
                        <select v-model="statusFilter" class="px-4 py-2 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="In Review">In Review</option>
                        </select>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="border-b-2 border-primary">
                                <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Student</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Course</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Country</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                v-for="student in filteredStudents"
                                :key="student.id"
                                class="border-b border-border hover:bg-muted/50 hover:border-l-2 hover:border-l-primary transition-all duration-200 cursor-pointer"
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
                                <td class="py-4 px-4 text-sm">{{ student.course }}</td>
                                <td class="py-4 px-4 text-sm">{{ student.country }}</td>
                                <td class="py-4 px-4">
                                        <span
                                            :class="student.statusClass"
                                            class="px-3 py-1 rounded-full text-xs font-medium transition-all duration-200"
                                        >
                                            {{ student.status }}
                                        </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-muted-foreground">{{ student.date }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary" style="animation-delay: 0.2s;">
                        <h3 class="font-bold mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <router-link
                                to="/applications/create"
                                class="flex items-center space-x-3 p-3 hover:bg-muted rounded-lg border border-transparent hover:border-primary transition-all duration-200 hover:scale-105"
                            >
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-sm">New Application</div>
                                    <div class="text-xs text-muted-foreground">Submit student application</div>
                                </div>
                            </router-link>
                            <router-link
                                to="/team"
                                class="flex items-center space-x-3 p-3 hover:bg-muted rounded-lg border border-transparent hover:border-primary transition-all duration-200 hover:scale-105"
                            >
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-sm">View Team</div>
                                    <div class="text-xs text-muted-foreground">BDO officers</div>
                                </div>
                            </router-link>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary" style="animation-delay: 0.3s;">
                        <h3 class="font-bold mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <div v-for="activity in recentActivity" :key="activity.id" class="flex items-start space-x-3 hover:bg-muted/50 p-2 rounded-lg transition-all duration-200">
                                <div class="w-2 h-2 bg-primary rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm">{{ activity.text }}</p>
                                    <p class="text-xs text-muted-foreground mt-1">{{ activity.time }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useTheme } from '../composables/useTheme';
import LineChart from '../components/LineChart.vue';
import DoughnutChart from '../components/DoughnutChart.vue';
import BarChart from '../components/BarChart.vue';
import Navigation from '../components/Navigation.vue';

export default {
    name: 'Dashboard',
    components: {
        LineChart,
        DoughnutChart,
        BarChart,
        Navigation
    },
    setup() {
        const { isDark, toggleTheme } = useTheme();

        const user = ref({
            name: 'John Doe',
            agency: 'Global Education Agency',
            initials: 'JD'
        });

        const stats = [
            {
                value: 248,
                label: 'Total Students',
                change: '+12%',
                changeColor: 'text-primary',
                bgColor: 'bg-primary/20',
                iconColor: 'text-primary',
                icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
            },
            {
                value: 42,
                label: 'Pending Applications',
                change: '+8%',
                changeColor: 'text-blue-500',
                bgColor: 'bg-blue-500/20',
                iconColor: 'text-blue-500',
                icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
            },
            {
                value: 186,
                label: 'Approved',
                change: '+24%',
                changeColor: 'text-emerald-500',
                bgColor: 'bg-emerald-500/20',
                iconColor: 'text-emerald-500',
                icon: 'M9 12l2 2 4-4m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
            },
            {
                value: 20,
                label: 'In Review',
                change: '-5%',
                changeColor: 'text-amber-500',
                bgColor: 'bg-amber-500/20',
                iconColor: 'text-amber-500',
                icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
            }
        ];

        const applicationsChartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Total Applications',
                    data: [30, 45, 38, 52, 48, 62],
                    borderColor: 'rgb(0, 102, 255)',
                    backgroundColor: 'rgba(0, 102, 255, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                },
                {
                    label: 'Approved',
                    data: [22, 32, 28, 38, 35, 45],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 2
                },
                {
                    label: 'Pending',
                    data: [5, 8, 6, 9, 8, 11],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 2
                },
                {
                    label: 'In Review',
                    data: [3, 5, 4, 5, 5, 6],
                    borderColor: 'rgb(245, 158, 11)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 2
                }
            ]
        };

        const statusChartData = {
            labels: ['Approved', 'Pending', 'In Review', 'Rejected'],
            datasets: [{
                data: [186, 42, 20, 8],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 0
            }]
        };

        const monthlyChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Applications',
                data: [45, 52, 48, 65, 58, 72, 68, 75, 82, 78, 85, 92],
                backgroundColor: 'rgba(0, 102, 255, 0.8)',
                borderColor: 'rgb(0, 102, 255)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(0, 102, 255, 1)'
            }]
        };

        const searchQuery = ref('');
        const statusFilter = ref('');

        const students = ref([
            {
                id: 1,
                name: 'Sarah Johnson',
                email: 'sarah.j@email.com',
                initials: 'SJ',
                course: 'Computer Science',
                country: 'United Kingdom',
                status: 'Approved',
                statusClass: 'bg-emerald-500/20 text-emerald-500',
                date: '2 days ago'
            },
            {
                id: 2,
                name: 'Michael Chen',
                email: 'michael.c@email.com',
                initials: 'MC',
                course: 'Business Administration',
                country: 'Canada',
                status: 'In Review',
                statusClass: 'bg-amber-500/20 text-amber-500',
                date: '3 days ago'
            },
            {
                id: 3,
                name: 'Emma Williams',
                email: 'emma.w@email.com',
                initials: 'EW',
                course: 'Engineering',
                country: 'Australia',
                status: 'Pending',
                statusClass: 'bg-blue-500/20 text-blue-500',
                date: '5 days ago'
            },
            {
                id: 4,
                name: 'David Brown',
                email: 'david.b@email.com',
                initials: 'DB',
                course: 'Medicine',
                country: 'United States',
                status: 'Approved',
                statusClass: 'bg-emerald-500/20 text-emerald-500',
                date: '1 week ago'
            },
            {
                id: 5,
                name: 'Lisa Anderson',
                email: 'lisa.a@email.com',
                initials: 'LA',
                course: 'Law',
                country: 'United Kingdom',
                status: 'In Review',
                statusClass: 'bg-amber-500/20 text-amber-500',
                date: '1 week ago'
            }
        ]);

        const recentActivity = ref([
            { id: 1, text: 'New application submitted by Sarah Johnson', time: '2 hours ago' },
            { id: 2, text: 'Application approved for Michael Chen', time: '5 hours ago' },
            { id: 3, text: 'Document uploaded for Emma Williams', time: '1 day ago' },
            { id: 4, text: 'Status updated for David Brown', time: '2 days ago' }
        ]);

        const filteredStudents = computed(() => {
            let filtered = students.value;

            if (searchQuery.value) {
                filtered = filtered.filter(student =>
                    student.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    student.email.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            }

            if (statusFilter.value) {
                filtered = filtered.filter(student => student.status === statusFilter.value);
            }

            return filtered;
        });

        return {
            user,
            stats,
            applicationsChartData,
            statusChartData,
            monthlyChartData,
            students,
            searchQuery,
            statusFilter,
            filteredStudents,
            recentActivity,
            isDark,
            toggleTheme
        };
    }
};
</script>
