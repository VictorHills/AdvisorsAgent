<template>
    <Transition name="slide-down">
        <div v-if="showBanner"
             :class="[
                 'fixed top-0 left-0 right-0 z-[9999] px-4 py-3 shadow-lg',
                 isOnline ? 'bg-emerald-500' : 'bg-red-500'
             ]">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- Offline Icon -->
                    <svg v-if="!isOnline" class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"/>
                    </svg>

                    <!-- Online Icon -->
                    <svg v-else class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    <div class="text-white">
                        <p class="text-sm font-medium">
                            {{ isOnline ? 'Back Online' : 'No Internet Connection' }}
                        </p>
                        <p class="text-xs opacity-90">
                            {{
                                isOnline ? 'Your connection has been restored' : 'Please check your internet connection'
                            }}
                        </p>
                    </div>
                </div>

                <!-- Close button for online state -->
                <button v-if="isOnline"
                        @click="closeBanner"
                        class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import {ref, onMounted, onUnmounted} from 'vue'

const isOnline = ref(navigator.onLine)
const showBanner = ref(false)
let hideTimeout = null

const updateOnlineStatus = () => {
    const wasOnline = isOnline.value
    isOnline.value = navigator.onLine

    // Show banner when status changes
    if (wasOnline !== isOnline.value) {
        showBanner.value = true

        // Clear any existing timeout
        if (hideTimeout) {
            clearTimeout(hideTimeout)
        }

        // Auto-hide "Back Online" banner after 5 seconds
        if (isOnline.value) {
            hideTimeout = setTimeout(() => {
                showBanner.value = false
            }, 5000)
        }
    }
}

const closeBanner = () => {
    showBanner.value = false
    if (hideTimeout) {
        clearTimeout(hideTimeout)
    }
}

onMounted(() => {
    window.addEventListener('online', updateOnlineStatus)
    window.addEventListener('offline', updateOnlineStatus)

    // Optional: Periodic check for connection (every 30 seconds)
    const checkInterval = setInterval(() => {
        if (!navigator.onLine && isOnline.value) {
            updateOnlineStatus()
        }
    }, 30000)

    // Store interval ID for cleanup
    onUnmounted(() => {
        clearInterval(checkInterval)
    })
})

onUnmounted(() => {
    window.removeEventListener('online', updateOnlineStatus)
    window.removeEventListener('offline', updateOnlineStatus)
    if (hideTimeout) {
        clearTimeout(hideTimeout)
    }
})
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.3s ease;
}

.slide-down-enter-from {
    transform: translateY(-100%);
    opacity: 0;
}

.slide-down-leave-to {
    transform: translateY(-100%);
    opacity: 0;
}
</style>
