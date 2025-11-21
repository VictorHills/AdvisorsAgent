<template>
    <div class="min-h-screen bg-background animate-fade-in">

        <main class="container mx-auto px-6 py-8">
            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
            </div>

            <div v-else>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div v-for="(stat, index) in stats" :key="index"
                         class="glass-card p-6 rounded-xl animate-slide-up hover:shadow-lg hover:border-primary transition-all duration-300 hover:-translate-y-1"
                         :style="{ animationDelay: `${index * 0.1}s` }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center" :class="stat.bgColor">
                                <svg class="w-6 h-6" :class="stat.iconColor" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          :d="stat.icon"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium" :class="stat.changeColor">{{ stat.change }}</span>
                        </div>
                        <div class="text-3xl font-bold mb-1">{{ stat.value }}</div>
                        <div class="text-sm text-muted-foreground">{{ stat.label }}</div>
                    </div>
                </div>

                <!--                <div class="mb-8">
                                    <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary"
                                         style="animation-delay: 0.3s;">
                                        <h3 class="font-bold mb-6">Monthly Applications Overview</h3>
                                        <div class="h-80">
                                            <BarChart v-if="monthlyChartData && Object.keys(monthlyChartData).length > 0" :data="monthlyChartData"/>
                                            <div v-else class="flex items-center justify-center h-full text-muted-foreground">
                                                No data available
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                                    <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary"
                                         style="animation-delay: 0.4s;">
                                        <h3 class="font-bold mb-6">Applications Trend</h3>
                                        <div class="h-64">
                                            <LineChart :data="applicationsChartData"/>
                                        </div>
                                    </div>
                                    <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary"
                                         style="animation-delay: 0.5s;">
                                        <h3 class="font-bold mb-6">Applications by Status</h3>
                                        <div class="h-64">
                                            <DoughnutChart v-if="statusChartData && Object.keys(statusChartData).length > 0" :data="statusChartData"/>
                                            <div v-else class="flex items-center justify-center h-full text-muted-foreground">
                                                No data available
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 glass-card rounded-xl p-6 animate-slide-up border-t-2 border-primary">


                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                <tr class="border-b-2 border-primary">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Student Full Name
                                    </th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Email
                                    </th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Phone
                                    </th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Gender
                                    </th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Country
                                    </th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted-foreground">
                                        Enrolled Date
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="student in limitedStudents"
                                    :key="student.id"
                                    class="border-b border-border hover:bg-muted/50 hover:border-l-2 hover:border-l-primary transition-all duration-200 cursor-pointer"
                                >
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-primary text-sm font-medium">{{
                                                        student.initials
                                                    }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ student.name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm">{{ student.email }}</td>
                                    <td class="py-4 px-4 text-sm">{{ student.phone }}</td>
                                    <td class="py-4 px-4 text-sm">{{ student.gender }}</td>
                                    <td class="py-4 px-4 text-sm">{{ student.country }}</td>
                                    <td class="py-4 px-4 text-sm text-muted-foreground">{{ student.date }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary"
                             style="animation-delay: 0.2s;">
                            <h3 class="font-bold mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <router-link
                                    to="/applications/create"
                                    class="flex items-center space-x-3 p-3 hover:bg-muted rounded-lg border border-transparent hover:border-primary transition-all duration-200 hover:scale-105"
                                >
                                    <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">New Application</div>
                                        <div class="text-xs text-muted-foreground">Submit student application</div>
                                    </div>
                                </router-link>

                                <router-link
                                    to="/create-student"
                                    class="flex items-center space-x-3 p-3 hover:bg-muted rounded-lg border border-transparent hover:border-primary transition-all duration-200 hover:scale-105"
                                >
                                    <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">New Student</div>
                                        <div class="text-xs text-muted-foreground">Add a new student</div>
                                    </div>
                                </router-link>

                            </div>
                        </div>

                        <div class="glass-card rounded-xl p-6 animate-slide-up border-l-4 border-primary"
                             style="animation-delay: 0.3s;">
                            <h3 class="font-bold mb-4">Recent Activity</h3>
                            <div v-if="loadingActivity" class="flex items-center justify-center py-8">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                            </div>
                            <div v-else-if="limitedRecentActivity.length === 0"
                                 class="text-center py-8 text-muted-foreground text-sm">
                                No recent activity
                            </div>
                            <div v-else class="space-y-4">
                                <div v-for="activity in limitedRecentActivity" :key="activity.id"
                                     class="flex items-start space-x-3 hover:bg-muted/50 p-2 rounded-lg transition-all duration-200">
                                    <div class="w-2 h-2 bg-primary rounded-full mt-2 flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm break-words">{{ activity.text }}</p>
                                        <p class="text-xs text-muted-foreground mt-1">{{ activity.time }}</p>
                                    </div>
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
import {computed, onMounted, ref} from 'vue';
import {useTheme} from '../composables/useTheme';
import {applicationsAPI, dashboardAPI, studentsAPI} from '../services/api';
import LineChart from '../components/LineChart.vue';
import DoughnutChart from '../components/DoughnutChart.vue';
import BarChart from '../components/BarChart.vue';
import Navigation from '../components/Navigation.vue';

export default {
    name: 'Dashboard',
    components: {
        LineChart,
        // DoughnutChart,
        // BarChart,
        Navigation
    },
    setup() {
        const {isDark, toggleTheme} = useTheme();

        const loading = ref(true);
        const loadingActivity = ref(true);
        const stats = ref([]);
        const applicationsChartData = ref({});
        const statusChartData = ref({});
        const monthlyChartData = ref({});
        const students = ref([]);
        const recentActivity = ref([]);

        const fetchDashboardData = async () => {
            try {
                loading.value = true;

                const [statsRes, trendRes, statusRes, monthlyRes, studentRes] = await Promise.all([
                    dashboardAPI.getStats(),
                    dashboardAPI.getApplicationsTrend(),
                    dashboardAPI.getApplicationsStatus(),
                    dashboardAPI.getMonthlyApplications(),
                    studentsAPI.getAll()
                ]);

                const statsData = statsRes.data.data || statsRes.data;

                stats.value = [
                    {
                        value: statsData.total_students || 0,
                        label: 'Total Students',
                        change: '+12%',
                        changeColor: 'text-primary',
                        bgColor: 'bg-primary/20',
                        iconColor: 'text-primary',
                        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                    },
                    {
                        value: statsData.pending_applications || 0,
                        label: 'Pending Applications',
                        change: '+8%',
                        changeColor: 'text-blue-500',
                        bgColor: 'bg-blue-500/20',
                        iconColor: 'text-blue-500',
                        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                    },
                    {
                        value: statsData.approved_applications || 0,
                        label: 'Application Submitted',
                        change: '+24%',
                        changeColor: 'text-emerald-500',
                        bgColor: 'bg-emerald-500/20',
                        iconColor: 'text-emerald-500',
                        icon: 'M9 12l2 2 4-4m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    },
                    {
                        value: statsData.in_review_applications || 0,
                        label: 'Student Enrolled',
                        change: '-5%',
                        changeColor: 'text-amber-500',
                        bgColor: 'bg-amber-500/20',
                        iconColor: 'text-amber-500',
                        icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    }
                ];

                applicationsChartData.value = trendRes.data.data || trendRes.data;
                statusChartData.value = statusRes.data.data || statusRes.data;
                monthlyChartData.value = monthlyRes.data.data || monthlyRes.data;

                const applicationsData = Array.isArray(studentRes.data) ? studentRes.data : (studentRes.data.data || []);

                students.value = applicationsData.map(app => ({
                    id: app.id,
                    name: `${app.first_name} ${app.middle_name} ${app.last_name}`,
                    email: app.email,
                    phone: app.phone_number,
                    gender: app.gender,
                    initials: `${app.first_name[0]}${app.last_name[0]}`,
                    country: app.country,
                    date: new Date(app.created_at).toLocaleDateString()
                }));

            } catch (error) {
                console.error('[v0] Error fetching dashboard data:', error);
            } finally {
                loading.value = false;
            }
        };

        const fetchRecentActivity = async () => {
            try {
                loadingActivity.value = true;
                const response = await dashboardAPI.getRecentActivity();
                recentActivity.value = response.data;
            } catch (error) {
                console.error('[v0] Error fetching recent activity:', error);
                recentActivity.value = [];
            } finally {
                loadingActivity.value = false;
            }
        };

        const getStatusClass = (status) => {
            const statusMap = {
                'Application Submitted': 'bg-emerald-500/20 text-emerald-500',
                'Pending': 'bg-blue-500/20 text-blue-500',
                'Student Enrolled': 'bg-amber-500/20 text-amber-500',
                'Rejected': 'bg-red-500/20 text-red-500'
            };
            return statusMap[status] || 'bg-gray-500/20 text-gray-500';
        };

        const limitedStudents = computed(() => students.value.slice(0, 8));
        const limitedRecentActivity = computed(() => recentActivity.value.slice(0, 5));

        onMounted(() => {
            fetchDashboardData();
            fetchRecentActivity();
        });

        return {
            loading,
            loadingActivity,
            stats,
            applicationsChartData,
            statusChartData,
            monthlyChartData,
            students,
            limitedStudents,
            limitedRecentActivity,
            recentActivity,
            isDark,
            toggleTheme
        };
    }
};
</script>
