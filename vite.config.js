import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/publik.js',
                'resources/css/laporan_create.css',
                'resources/js/laporan_create.js',
                'resources/css/laporan_edit.css',
                'resources/js/laporan_edit.js',
                'resources/css/menu_create.css',
                'resources/js/menu_create.js',
                'resources/css/menu_edit.css',
                'resources/js/menu_edit.js',
                'resources/css/ggg.css',
                'resources/js/ggg.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
