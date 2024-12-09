import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
        host: '0.0.0.0', // Allow access from all network interfaces
        port: 5173, // Vite development server
        strictPort: true,
        hmr: {
            host: 'localhost', // HMR should match the Laravel backend domain
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
