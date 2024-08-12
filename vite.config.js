import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Ensure this file imports Bootstrap SCSS
                'resources/js/app.js', // Ensure this file imports Bootstrap JavaScript
            ],
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
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
    server: {
        hmr: {
            overlay: false, // Disable HMR overlay
        },
    },
});
