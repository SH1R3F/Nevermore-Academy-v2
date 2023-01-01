import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
import App from "./Layouts/App.vue";
import { InertiaProgress } from "@inertiajs/progress";
import route from "ziggy-js";

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
            .component("Head", Head)
            .mixin({ methods: { route } })
            .use(plugin)
            .mount(el);
    },
    title: (title) => `${title} - Nevermore academy`,
});
InertiaProgress.init({
    color: "red",
});
