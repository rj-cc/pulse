import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny, fontsource } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/admin/theme.css'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
                bunny('Manrope', {
                    weights: [400, 500, 600, 700, 800],
                }),
                bunny('Fraunces', {
                    weights: [600, 700],
                }),
                bunny('Inter', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('Source Serif 4', {
                    weights: [400, 600, 700],
                }),
                bunny('Source Sans 3', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('Plus Jakarta Sans', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('Lora', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('DM Sans', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('Merriweather', {
                    weights: [400, 700],
                }),
                bunny('Mulish', { 
                    weights: [400, 500, 600, 700],
                }),
                fontsource('Lexend', {
                    weights: [400, 500, 600, 700],
                }),
                fontsource('Space Grotesk', {
                    weights: [400, 500, 600, 700],
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
