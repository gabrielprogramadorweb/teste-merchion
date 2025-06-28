import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import { webcrypto } from 'crypto'

globalThis.crypto = webcrypto

export default defineConfig({
    plugins: [vue()],
    define: {
        'process.env': {}
    },
    optimizeDeps: {
        include: ['crypto']
    },
    server: {
        proxy: {
            '/api': 'http://localhost:8080',
            '/sanctum': 'http://localhost:8080'
        }
    },
    build: {
        outDir: '../public/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: 'src/main.js'
        }
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src')
        }
    }
})
