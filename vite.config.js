import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        sourcemap: true,
    },
    css: {
        devSourcemap: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/public.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/ui.js',
                'resources/js/app_ui.js',
            ],
            refresh: true,
        }),
    ],
    
});
