import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        }
    },
    plugins: [
        laravel({
            input: ['resources/scss/admin/admin.scss',
            'resources/less/minisite.less',
            'resources/less/directory.less',
            'resources/js/app.js',
            'resources/scss/admin/app.scss',
            'resources/js/minisite.js',
            'resources/js/minisite-orp.js',
            'resources/js/booking-widget.js',
            'resources/less/orp-ui/orp-ui.less',
            'resources/js/frontend.js',
            'resources/js/bulma-playground.js'],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => tag.startsWith('trix-')
                }
            }
        }),
    ],
    server: {
         host: 'acerca.local',
            port: 5173,
            hmr: {
                host: 'acerca.local',
            },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
