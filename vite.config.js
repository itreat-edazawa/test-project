import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { resolve } from 'path'
import fs from 'fs'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        {
            name: 'copy-manifest-to-public',
            closeBundle() {
                const src = '.vercel/output/static/build/manifest.json'
                const dest = 'public/build/manifest.json'
                fs.mkdirSync('public/build', { recursive: true })
                fs.copyFileSync(src, dest)
            }
        }
    ],
    build: {
        outDir: '.vercel/output/static/build',
        emptyOutDir: true,
        manifest: true,
    },
})