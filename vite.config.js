import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/tabler-css.js',
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
