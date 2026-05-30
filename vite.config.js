import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin/admin-styles.css',
                'resources/js/app.js',
                'resources/css/empresa/empresa.css',
                'resources/images/logo-sinfondo.png',
                'resources/css/auth/auth.css',
                'resources/js/dashboard.js',
                'resources/js/login.js',
                'resources/css/dashboard/dashboard.css',
                'resources/images/fondo-poli-8.jpg',
                'resources/images/fondo-poli-13.jpg',
                'resources/images/fondo-poli-1.jpg',
                'resources/css/pdf/pdf.css'

            ],
            refresh: true,
        }),
    ],
});
