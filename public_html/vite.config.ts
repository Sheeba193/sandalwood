import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.ts'
            ],
            ssr: 'resources/js/ssr.ts',
            refresh: [
                'resources/views/**',
                'resources/js/**',
                'resources/css/**',
                'app/**',
                'routes/**'
            ],
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        watch: {
            ignored: [
                '**/vendor/**',
                '**/node_modules/**',
                '**/storage/**',
                '**/bootstrap/cache/**',
                '**/public/**'
            ]
        }
    },
    build: {
        sourcemap: false,
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', '@inertiajs/vue3'],
                    utils: ['@vueuse/core', 'clsx', 'tailwind-merge']
                }
            }
        }
    },
    optimizeDeps: {
        include: ['vue', '@inertiajs/vue3']
    }
});