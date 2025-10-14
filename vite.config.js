import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'; // Import the Vue plugin

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/frontend/main.js',
                'resources/frontend/app.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
});
