import * as Sentry from "@sentry/browser";
import {Vue as VueIntegration} from "@sentry/integrations";
import {Integrations} from "@sentry/tracing";

Sentry.init({
    dsn: MIX_SENTRY_DSN,
    integrations: [
        new VueIntegration({
            Vue,
            tracing: true,
        }),

        new Integrations.BrowserTracing(),
    ],

    // We recommend adjusting this value in production, or using tracesSampler
    // for finer control
    tracesSampleRate: 1.0,
});


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home-component', require('./components/HomeComponent.vue').default);
Vue.component('about-component', require('./components/AboutComponent.vue').default);
Vue.component('nav-component', require('./components/NavComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('whoami-component', require('./components/WhoamiComponent.vue').default);


Sentry.init({
    dsn: MIX_SENTRY_DSN,
    integrations: [
        new Sentry.Integrations.Vue({
            Vue,
            tracing: true,
        }),
        new Sentry.Integrations.BrowserTracing(),
    ],

    // We recommend adjusting this value in production, or using tracesSampler
    // for finer control
    tracesSampleRate: 1.0,
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
