require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueApexCharts from "vue3-apexcharts";
import Datepicker from 'vue3-date-time-picker';
import VueSnip from 'vue-snip';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueApexCharts)
            .use(VueSnip)
            .mixin({ methods: { route } })
            .component('Datepicker', Datepicker)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
