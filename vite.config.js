import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/tabler.min.css',
                'resources/js/tabler.min.js',
            ],
            refresh: true,
            // refresh: [
            //     ...refreshPaths,
            //     'app/Http/Livewire/**',
            // ],
        }),
    ],
});
