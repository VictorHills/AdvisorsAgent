import { ref, onMounted, onUnmounted, computed } from 'vue'

export function useNetwork() {
    const isOnline = ref(navigator.onLine)
    const offlineSince = ref(null)

    const updateOnlineStatus = (event) => {
        const previousStatus = isOnline.value
        isOnline.value = event.type === 'online'

        if (!isOnline.value && !offlineSince.value) {
            offlineSince.value = new Date()
        } else if (isOnline.value) {
            offlineSince.value = null
        }

        // Log for debugging
        console.log(`[Network] Status changed: ${previousStatus ? 'online' : 'offline'} → ${isOnline.value ? 'online' : 'offline'}`)
    }

    const checkConnection = async () => {
        try {
            // Ping your API or a reliable endpoint
            const response = await fetch('/api/health', {
                method: 'HEAD',
                cache: 'no-cache'
            })
            return response.ok
        } catch (error) {
            return false
        }
    }

    // Computed property to use in :disabled bindings
    const isOffline = computed(() => !isOnline.value)

    onMounted(() => {
        window.addEventListener('online', updateOnlineStatus)
        window.addEventListener('offline', updateOnlineStatus)

        // Initial check
        if (!navigator.onLine) {
            offlineSince.value = new Date()
        }
    })

    onUnmounted(() => {
        window.removeEventListener('online', updateOnlineStatus)
        window.removeEventListener('offline', updateOnlineStatus)
    })

    return {
        isOnline,
        isOffline,
        offlineSince,
        checkConnection
    }
}

// Global singleton instance
let networkInstance = null

export function getNetworkInstance() {
    if (!networkInstance) {
        networkInstance = {
            isOnline: ref(navigator.onLine),
            isOffline: computed(() => !networkInstance.isOnline.value)
        }

        const updateStatus = (event) => {
            networkInstance.isOnline.value = event.type === 'online'
        }

        window.addEventListener('online', updateStatus)
        window.addEventListener('offline', updateStatus)
    }

    return networkInstance
}
