import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import fs from 'fs'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        {
            name: 'laravel-vercel-manifest-fix',
            closeBundle() {
                const src = '.vercel/output/static/build/.vite/manifest.json'
                const dest = 'public/build/manifest.json'

                if (fs.existsSync(src)) {
                    fs.mkdirSync('public/build', { recursive: true })
                    fs.copyFileSync(src, dest)
                    console.log('manifest copied for laravel')
                } else {
                    console.log('manifest not found, skip copy')
                }
            }
        }
    ],
    build: {
        outDir: '.vercel/output/static/build',
        emptyOutDir: true,
        manifest: true,
    },
})