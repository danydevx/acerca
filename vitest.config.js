import { defineConfig } from 'vitest/config'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath } from 'node:url'

export default defineConfig({
    plugins: [
        vue(),
    ],
    test: {
        globals: true,
        environment: 'jsdom',
        include: [
            'resources/js/**/*.spec.{js,ts}',
            'resources/js/**/*.test.{js,ts}',
        ],
        exclude: [
            'node_modules/**',
            'vendor/**',
            'public/**',
        ],
        coverage: {
            provider: 'v8',
            reporter: ['text', 'json', 'html'],
            include: [
                'resources/js/Composables/**',
                'resources/js/Components/OrpUI/**',
            ],
            exclude: [
                '**/*.d.ts',
                '**/*.spec.js',
                '**/*.test.js',
            ],
        },
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        },
    },
})
