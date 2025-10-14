<template>
    <div class="min-h-screen bg-muted/30">
        <header class="bg-background border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary rounded-lg"></div>
                        <h1 class="text-xl font-bold">AdvisorsAgent</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm text-muted-foreground">{{ userEmail }}</span>
                        <button
                            @click="handleLogout"
                            class="px-4 py-2 text-sm font-medium text-muted-foreground hover:text-foreground transition-colors"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-card rounded-lg border border-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Total Applications</p>
                            <p class="text-3xl font-bold mt-2">{{ stats.totalApplications }}</p>
                        </div>
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-card rounded-lg border border-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Active Students</p>
                            <p class="text-3xl font-bold mt-2">{{ stats.activeStudents }}</p>
                        </div>
                        <div class="w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-card rounded-lg border border-border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">This Month</p>
                            <p class="text-3xl font-bold mt-2">{{ stats.thisMonth }}</p>
                        </div>
                        <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Student Applications</h2>
                <router-link
                    to="/applications/create"
                    class="px-4 py-2 bg-primary text-primary-foreground rounded-lg font-medium hover:opacity-90 transition-opacity"
                >
                    + New Application
                </router-link>
            </div>

            <div class="bg-card rounded-lg border border-border overflow-hidden">
                <div v-if="loading" class="p-8 text-center">
                    <p class="text-muted-foreground">Loading applications...</p>
                </div>

                <div v-else-if="applications.length === 0" class="p-8 text-center">
                    <p class="text-muted-foreground mb-4">No applications yet</p>
                    <router-link
                        to="/applications/create"
                        class="inline-block px-4 py-2 bg-primary text-primary-foreground rounded-lg font-medium hover:opacity-90 transition-opacity"
                    >
                        Create your first application
                    </router-link>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-muted/50 border-b border-border">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Student Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Country
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Degree
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                Date
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                        <tr
                            v-for="application in applications"
                            :key="application.id"
                            class="hover:bg-muted/30 transition-colors"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">
                                    {{ application.first_name }} {{ application.last_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                                {{ application.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                                {{ application.phone_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ application.country }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ application.class_of_degree }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                                {{ formatDate(application.created_at) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '../utils/api'

const router = useRouter()
const userEmail = ref(localStorage.getItem('user_email') || 'Agent')
const loading = ref(true)
const applications = ref([])
const stats = ref({
    totalApplications: 0,
    activeStudents: 0,
    thisMonth: 0
})

const fetchApplications = async () => {
    loading.value = true
    try {
        await new Promise(resolve => setTimeout(resolve, 500))
        applications.value = []

        stats.value = {
            totalApplications: applications.value.length,
            activeStudents: applications.value.length,
            thisMonth: applications.value.filter(app => {
                const date = new Date(app.created_at)
                const now = new Date()
                return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear()
            }).length
        }
    } catch (error) {
        console.error('[v0] Error fetching applications:', error)
    } finally {
        loading.value = false
    }
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const handleLogout = async () => {
    try {
        await api.logout()
    } catch (error) {
        console.error('[v0] Logout error:', error)
    } finally {
        router.push('/login')
    }
}

onMounted(() => {
    fetchApplications()
})
</script>
