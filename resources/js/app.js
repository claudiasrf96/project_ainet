
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);  

import Vuex from 'vuex'; 
Vue.use(Vuex);

import Vuetify from 'vuetify';
Vue.use(Vuetify)

import store from './stores/global-store';

import VueSocketio from 'vue-socket.io';


import VeeValidate from 'vee-validate';

import Toasted from 'vue-toasted';

Vue.use(VeeValidate);

Vue.use(new VueSocketio({
 debug: true,
 connection: 'http://127.0.0.1:8080'
})); 


Vue.use(Toasted, {
    position: 'bottom-center',
    duration: 5000,
    type: 'info',
});



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const layout = Vue.component('layout-user', require('./components/Layout.vue'));

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
    el: '#app',
    data:{
    },
    store,
    $_veeValidate: {
        validator: 'new'
    },
    mounted() {
        this.$store.commit('loadTokenAndUserFromSession');
    },
    methods: {  
        
    },
    sockets:{   
        connect(){
            if(this.$store.state.user !== null){
                this.$socket.emit('user_enter', this.$store.state.user);
            }
        },
    }       
});
