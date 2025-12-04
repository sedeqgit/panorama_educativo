import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/chart.js', 'resources/css/charts.css', 'resources/css/tables.css', 'resources/css/high-school-tables.css', 'resources/css/university-tables.css'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
