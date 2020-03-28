/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

Vue.component('post-form', require('./components/PostForm.vue').default);
Vue.component('service-manager', require('./components/ServiceManager.vue').default);
Vue.component('post-manager', require('./components/PostManager.vue').default);
Vue.component('service-form', require('./components/ServiceForm.vue').default);
Vue.component('category-manager', require('./components/CategoryManager.vue').default);
Vue.component('tag-manager', require('./components/TagManager.vue').default);
Vue.component('contact-manager', require('./components/ContactManager.vue').default);
Vue.component('faq-manager', require('./components/FaqManager.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);
Vue.component('subscribe-form', require('./components/SubscribeForm.vue').default);
Vue.component('accordion-list', require('./components/AccordionList.vue').default);
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('site-info', require('./components/SiteInfo.vue').default);
Vue.component('subscriber-manager', require('./components/SubscriberManager.vue').default);
Vue.component('legal-manager', require('./components/LegalManager.vue').default);
Vue.component('profile-form', require('./components/ProfileForm.vue').default);
Vue.component('site-setting', require('./components/SiteSetting.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
