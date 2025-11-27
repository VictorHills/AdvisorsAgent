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

const formattedData = computed(() => {
    if (!props.data?.labels || !props.data?.data) return null
    return {
        labels: props.data.labels,
        datasets: [{
            label: 'Applications',
            data: props.data.data,
            backgroundColor: '#6366F1',
            borderColor: '#4F46E5',
            borderWidth: 1,
            borderRadius: 6,
            hoverBackgroundColor: '#4F46E5'
        }]
    }
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            padding: 12,
            titleColor: '#fff',
            bodyColor: '#fff'
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
            ticks: { color: '#6b7280' }
        },
        x: {
            grid: { display: false },
            ticks: { color: '#6b7280', maxRotation: 45, minRotation: 45 }
        }
    }
}
</script>
