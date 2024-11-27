import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Allow access from all network interfaces
        port: 5173, // Explicitly set the port
        strictPort: true, // Ensure the port isn't dynamically changed
        hmr: {
            host: 'localhost', // Ensure HMR (Hot Module Replacement) works correctly
        },
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
