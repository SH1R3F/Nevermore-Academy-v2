import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import App from "./Layouts/App.vue";

createInertiaApp({
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default;
        if (page.layout === undefined && !name.startsWith("Public/")) {
            page.layout = App;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
