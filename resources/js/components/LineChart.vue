<template>
    <Line v-if="formattedData" :data="formattedData" :options="chartOptions"/>
</template>

<script setup>
import {computed} from 'vue'
import {Line} from 'vue-chartjs'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
} from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler)

const props = defineProps({
    data: {type: Object, required: true}
})

const colors = [
    {bg: 'rgba(255,0,0,0.2)', border: '#FF0000'},    // Pure Red
    {bg: 'rgba(0,255,0,0.2)', border: '#00FF00'},    // Pure Green
    {bg: 'rgba(0,0,255,0.2)', border: '#0000FF'},    // Pure Blue
    {bg: 'rgba(255,255,0,0.2)', border: '#FFFF00'},    // Yellow
    {bg: 'rgba(255,0,255,0.2)', border: '#FF00FF'},    // Magenta
    {bg: 'rgba(0,255,255,0.2)', border: '#00FFFF'},    // Cyan
    {bg: 'rgba(255,128,0,0.2)', border: '#FF8000'},    // Bright Orange
    {bg: 'rgba(128,0,255,0.2)', border: '#8000FF'}     // Deep Purple
];


const formattedData = computed(() => {
    if (!props.data?.labels || !props.data?.datasets) return null
    return {
        labels: props.data.labels,
        datasets: props.data.datasets.map((ds, i) => ({
            label: ds.label,
            data: ds.data,
            borderColor: colors[i % colors.length].border,
            backgroundColor: colors[i % colors.length].bg,
            borderWidth: 2,
            fill: i === 0,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: colors[i % colors.length].border,
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }))
    }
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {mode: 'index', intersect: false},
    plugins: {
        legend: {
            position: 'bottom',
            labels: {usePointStyle: true, padding: 15, color: '#6b7280'}
        },
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
            grid: {color: 'rgba(0,0,0,0.05)'},
            ticks: {color: '#6b7280'}
        },
        x: {
            grid: {display: false},
            ticks: {color: '#6b7280'}
        }
    }
}
</script>
