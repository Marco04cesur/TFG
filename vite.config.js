import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/petmatch_design_system.css', 
                'resources/css/petmatch_views.css', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
       
    ],
    server: {
        host: '127.0.0.1', /* <--- ESTA ES LA BALA DE PLATA */
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});