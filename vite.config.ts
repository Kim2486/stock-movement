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
        // ป้องกัน error บน Vercel
        ...(process.env.VERCEL ? [] : [wayfinder()]),
    ],
    // เพิ่มส่วนนี้เพื่อจัดการและซ่อน Warnings ของ CSS/LightningCSS ตอน Build
    css: {
        transformer: 'postcss', // สลับมาใช้ PostCSS แทน LightningCSS ในการแปลงโค้ด เพื่อเลี่ยงปัญหา Unknown at rule ของ Tailwind v4 บน Vercel
    },
});