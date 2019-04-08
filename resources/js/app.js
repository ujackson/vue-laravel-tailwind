
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueSweetalert2 from 'vue-sweetalert2';
 

import mixins from './mixins';
import routes from './routes';

Vue.use(VueRouter);
Vue.use(VueSweetalert2);
Vue.mixin(mixins);


const router = new VueRouter({
    mode: 'history',
    routes: routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!window.localStorage.getItem('access-token')) {
      next({
        path: '/login',
        query: { auth: 'expired' },
        replace: true
      })
    } else {
      next()
    }
  } else {
    next() 
  }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('app', require('./views/layouts/App.vue').default);
Vue.component('loader', require('./components/base/Loader.vue').default);
Vue.component('paginator', require('./components/base/Paginator.vue').default);
Vue.component('rating', require('./components/base/Rating.vue').default);
Vue.component('clock', require('./components/Clock.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
