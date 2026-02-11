import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 
                'resources/js/charts.js','resources/js/high-school-charts.js',
                'resources/js/university-charts.js', 'resources/css/charts.css', 
                'resources/css/tables.css', 'resources/css/high-school-tables.css', 
                'resources/css/university-tables.css', 'resources/css/barra.css', 
                'resources/css/federal.css', 'resources/css/navbar.css',
                'resources/js/graficos.js', 'resources/css/footer.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
