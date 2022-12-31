import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import App from "./Layouts/App.vue";
import { InertiaProgress } from "@inertiajs/progress";

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
            .component("Link", Link)
            .use(plugin)
            .mount(el);
    },
});
InertiaProgress.init({
    color: "red",
});
