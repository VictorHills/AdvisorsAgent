<template>
    <div id="app" class="min-h-screen bg-background text-foreground">
        <Navigation v-if="showNavigation"/>
        <InternetConnectivity/>
        <router-view :key="$route.fullPath"/>
    </div>
</template>

<script>
import {computed} from 'vue';
import {useRoute} from 'vue-router';
import Navigation from './Navigation.vue';
import InternetConnectivity from "./InternetConnectivity.vue";

export default {
    name: 'App',
    components: {
        InternetConnectivity,
        Navigation
    },
    setup() {
        const route = useRoute();

        const showNavigation = computed(() => {
            return route.path !== '/login' && route.path !== '/register';
        });

        return {
            showNavigation
        };
    }
};
</script>

<style>
/* Global styles */
</style>
