
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);  

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const login = Vue.component('loginUser', require('./components/loginUser.vue'));
const logout = Vue.component('logoutUser', require('./components/logoutUser.vue'));

const routes = [
    { path: '/', redirect: '/users', name: 'root'},
    { path: '/users', component: login, name: 'users'},
    { path: '/loginUser', component: login, name: 'login'},
    { path: '/logoutUser', component: logout, name: 'logout'},
];
const router = new VueRouter({//cria o componente rotas
    routes:routes
});
/*
Vue.component('login-user', require('./components/LoginUser.vue'));
Vue.component('layout-vue', require('./components/Layout.vue'));
*/
// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app', router //rotas acessiveis
});
