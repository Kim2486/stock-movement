import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        // ตรวจสอบว่าถ้าอยู่บน Vercel จะไม่เรียกใช้งาน wayfinder เพื่อป้องกัน error "php: command not found"
        ...(process.env.VERCEL ? [] : [wayfinder()]),
    ],
    build: {
        cssMinify: 'esbuild', // ใช้ esbuild บีบอัด CSS เพื่อป้องกัน warning สัญลักษณ์ Tailwind v4 ใน Build Log
    },
});