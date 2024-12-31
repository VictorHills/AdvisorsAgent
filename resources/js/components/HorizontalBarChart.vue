<template>
    <Bar v-if="formattedData" :data="formattedData" :options="chartOptions" />
</template>

<script setup>
import { computed } from 'vue'
import { Bar } from 'vue-chartjs'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

const props = defineProps({
    data: { type: Object, required: true }
})

const statusColors = {
    'Pending': '#3B82F6',
    'Approved': '#10B981',
    'Application Submitted': '#10B981',
    'In Review': '#F59E0B',
    'Student Enrolled': '#6366F1',
    'Rejected': '#EF4444',
    'Processing': '#8B5CF6',
    'Waitlisted': '#EC4899',
    'Documents Required': '#F97316',
    'Interview Scheduled': '#06B6D4',
    'Offer Sent': '#84CC16'
}

const defaultColors = [
    '#6366F1', '#10B981', '#3B82F6', '#F59E0B', '#EF4444',
    '#8B5CF6', '#EC4899', '#F97316', '#06B6D4', '#84CC16',
    '#14B8A6', '#A855F7', '#F43F5E', '#0EA5E9', '#22C55E',
    '#EAB308', '#D946EF', '#64748B', '#FB7185', '#2DD4BF', '#FBBF24'
]

const formattedData = computed(() => {
    if (!props.data?.labels || !props.data?.data) return null

    const bgColors = props.data.labels.map((label, index) =>
        statusColors[label] || defaultColors[index % defaultColors.length]
    )

    return {
        labels: props.data.labels,
        datasets: [{
            label: 'Applications',
            data: props.data.data,
            backgroundColor: bgColors,
            borderColor: bgColors.map(c => c),
            borderWidth: 1,
            borderRadius: 4,
            barThickness: 20
        }]
    }
})

const chartOptions = computed(() => ({
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            padding: 12,
            titleColor: '#fff',
            bodyColor: '#fff',
            callbacks: {
                label: (ctx) => {
                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0)
                    const pct = total > 0 ? ((ctx.parsed.x / total) * 100).toFixed(1) : 0
                    return ` ${ctx.parsed.x} applications (${pct}%)`
                }
            }
        }
    },
    scales: {
        x: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
            ticks: { color: '#6b7280' }
        },
        y: {
            grid: { display: false },
            ticks: {
                color: '#6b7280',
                font: { size: 11 }
            }
        }
    }
}))
</script>
