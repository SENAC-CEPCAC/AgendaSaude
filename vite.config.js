import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: [
                'resources/css/app.css', 
                'resources/js/app.js'],
=======
            input: ['resources/css/app.css', 'resources/js/app.js'],
>>>>>>> e3bff9f51c9937101bfb9c22db76fda344d4f13c
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
