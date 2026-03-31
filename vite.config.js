import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        port: 5173,  // Port par défaut de Vite
        host: '127.0.0.1',
        strictPort: false,  // Permet de trouver un port alternatif si celui-ci est pris
    },
});