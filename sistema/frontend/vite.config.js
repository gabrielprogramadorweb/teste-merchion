import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

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
    }
})
