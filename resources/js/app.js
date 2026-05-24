import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createPinia } from "pinia";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - Toko Online`,

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),

    setup({ el, App, props, plugin }) {
        if (typeof window !== "undefined") {
            window.Ziggy = props.initialPage.props.ziggy;
        }

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            // PERBAIKAN: Suntikkan data route dari Laravel ke Ziggy
            .use(ZiggyVue, props.initialPage.props.ziggy)
            .mount(el);
    },

    progress: { color: "#2563EB" },
});
