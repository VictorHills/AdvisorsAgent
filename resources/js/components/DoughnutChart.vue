<template>
    <div class="w-full h-full relative">
        <Doughnut v-if="formattedData" :data="formattedData" :options="chartOptions"/>
        <div v-if="formattedData" class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="text-center">
                <div class="text-2xl font-bold">{{ total }}</div>
                <div class="text-xs text-muted-foreground">Total</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue'
import {Doughnut} from 'vue-chartjs'
import {Chart as ChartJS, ArcElement, Tooltip, Legend} from 'chart.js'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
    data: {type: Object, required: true}
})

const statusColors = {
    'Pending': '#3B82F6',
    'Approved': '#10B981',
    'Application Submitted': '#10B981',
    'In Review': '#F59E0B',
    'Student Enrolled': '#6366F1',
    'Rejected': '#EF4444'
}
const defaultColors = ['#6366F1', '#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6']

const total = computed(() => props.data?.data?.reduce((a, b) => a + b, 0) || 0)

const formattedData = computed(() => {
    if (!props.data?.labels || !props.data?.data) return null
    return {
        labels: props.data.labels,
        datasets: [{
            data: props.data.data,
            backgroundColor: props.data.labels.map((l, i) => statusColors[l] || defaultColors[i % defaultColors.length]),
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 8
        }]
    }
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '65%',
    plugins: {
        legend: {
            position: 'bottom',
            labels: {usePointStyle: true, padding: 20, color: '#6b7280'}
        },
        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            padding: 12,
            titleColor: '#fff',
            bodyColor: '#fff',
            callbacks: {
                label: (ctx) => {
                    const t = ctx.dataset.data.reduce((a, b) => a + b, 0)
                    const pct = t > 0 ? ((ctx.parsed / t) * 100).toFixed(1) : 0
                    return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`
                }
            }
        }
    }
}
</script>
