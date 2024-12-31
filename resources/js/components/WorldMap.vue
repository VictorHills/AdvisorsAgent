<template>
    <div class="w-full h-full relative">
        <!-- Simple world map with markers -->
        <svg viewBox="0 0 1000 500" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <!-- World map outline (simplified) -->
            <rect x="0" y="0" width="1000" height="500" fill="#f3f4f6" />

            <!-- Continents (simplified shapes) -->
            <g fill="#e5e7eb" stroke="#d1d5db" stroke-width="1">
                <!-- North America -->
                <path d="M 100 80 Q 120 60 150 70 L 200 80 Q 220 90 230 110 L 240 140 Q 250 160 240 180 L 220 200 Q 200 210 180 200 L 150 190 Q 120 180 110 160 L 100 130 Q 90 100 100 80 Z" />

                <!-- South America -->
                <path d="M 220 220 Q 230 210 240 220 L 250 250 Q 260 280 250 310 L 240 340 Q 230 360 220 350 L 210 320 Q 200 290 205 260 L 210 240 Q 215 225 220 220 Z" />

                <!-- Europe -->
                <path d="M 460 90 Q 480 80 500 85 L 520 95 Q 530 105 525 120 L 515 135 Q 505 145 490 140 L 470 130 Q 455 120 460 105 L 460 90 Z" />

                <!-- Africa -->
                <path d="M 480 150 Q 500 145 520 155 L 540 175 Q 550 200 545 230 L 540 260 Q 535 285 525 300 L 510 310 Q 495 315 485 305 L 475 280 Q 470 250 475 220 L 480 190 Q 480 165 480 150 Z" />

                <!-- Asia -->
                <path d="M 550 80 Q 580 70 620 75 L 680 85 Q 720 95 750 110 L 780 130 Q 800 150 795 175 L 785 200 Q 770 220 750 215 L 720 210 Q 690 205 660 195 L 630 185 Q 600 175 580 165 L 560 150 Q 545 130 545 110 L 550 80 Z" />

                <!-- Australia -->
                <path d="M 750 320 Q 770 315 790 325 L 810 345 Q 820 365 810 380 L 790 390 Q 770 395 755 385 L 740 365 Q 735 345 750 320 Z" />
            </g>

            <!-- Student markers -->
            <g v-for="location in studentLocations" :key="location.country">
                <!-- Outer glow -->
                <circle
                    :cx="location.x"
                    :cy="location.y"
                    :r="location.size + 8"
                    fill="#3b82f6"
                    :opacity="location.opacity * 0.2"
                    class="animate-pulse"
                />
                <!-- Main marker -->
                <circle
                    :cx="location.x"
                    :cy="location.y"
                    :r="location.size"
                    fill="#3b82f6"
                    :opacity="location.opacity"
                    stroke="#ffffff"
                    stroke-width="2"
                    class="hover:opacity-100 transition-opacity cursor-pointer"
                    @mouseenter="hoveredLocation = location"
                    @mouseleave="hoveredLocation = null"
                >
                    <title>{{ location.country }}: {{ location.count }} students</title>
                </circle>
            </g>
        </svg>

        <!-- Hover tooltip -->
        <div v-if="hoveredLocation"
             class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg px-4 py-2 border border-gray-200 z-10">
            <div class="font-semibold text-sm">{{ hoveredLocation.country }}</div>
            <div class="text-xs text-gray-600">{{ hoveredLocation.count }} students</div>
        </div>

        <!-- Legend -->
        <div class="flex items-center justify-center mt-4 space-x-6 text-sm">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-full bg-blue-500 opacity-40"></div>
                <span class="text-gray-600">Few Students (1-15)</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-blue-500 opacity-70"></div>
                <span class="text-gray-600">Medium (16-30)</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-5 h-5 rounded-full bg-blue-500 opacity-100"></div>
                <span class="text-gray-600">Many Students (31+)</span>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue'

export default {
    name: 'WorldMap',
    props: {
        data: {
            type: Array,
            default: () => []
        }
    },
    setup(props) {
        const hoveredLocation = ref(null)

        // Sample student distribution data with SVG coordinates
        const defaultLocations = [
            { country: "United States", x: 180, y: 150, count: 45 },
            { country: "Canada", x: 160, y: 100, count: 28 },
            { country: "Mexico", x: 170, y: 180, count: 12 },
            { country: "United Kingdom", x: 480, y: 110, count: 32 },
            { country: "Germany", x: 510, y: 115, count: 20 },
            { country: "France", x: 490, y: 125, count: 18 },
            { country: "Nigeria", x: 500, y: 220, count: 15 },
            { country: "South Africa", x: 520, y: 310, count: 10 },
            { country: "India", x: 680, y: 180, count: 35 },
            { country: "China", x: 720, y: 140, count: 30 },
            { country: "Japan", x: 800, y: 140, count: 22 },
            { country: "Australia", x: 780, y: 360, count: 25 },
            { country: "Brazil", x: 240, y: 280, count: 14 }
        ]

        const studentLocations = computed(() => {
            const locations = props.data.length > 0 ? props.data : defaultLocations
            const maxCount = Math.max(...locations.map(l => l.count))

            return locations.map(location => ({
                ...location,
                size: 6 + (location.count / maxCount) * 18,
                opacity: 0.5 + (location.count / maxCount) * 0.5
            }))
        })

        return {
            hoveredLocation,
            studentLocations
        }
    }
}
</script>

<style scoped>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
