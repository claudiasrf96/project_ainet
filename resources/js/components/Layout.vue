<template>
    <div>

       <!-- <router-link to="/users" class="btn btn-primary"  role="button">Users</router-link>-->
        <menu-user></menu-user>
        <router-link to="/login-user"  class="btn btn-primary"  role="button">Login</router-link>
        <router-link to="/logout-user" class="btn btn-primary"  role="button">Logout</router-link>
        <router-view></router-view>
        <!--<button @click="loginUser">Login</button>-->
        
    </div>

    
</template>

<script>
    import VueRouter from 'vue-router';

    const login = Vue.component('login-user', require('./loginUser.vue'));
    const logout = Vue.component('logout-user', require('./logoutUser.vue'));
    const menu = Vue.component('menu-user', require('./menu.vue'));

    const routes = [
    { path: '/', redirect: '/login-user', name: 'root'},
    { path: '/menu-user', component: menu, name: 'menu'},
    { path: '/login-user', component: login, name: 'login'},
    { path: '/logout-user', component: logout, name: 'logout'},
    ];

    const router = new VueRouter({//cria o componente rotas
        routes:routes
    });    

    export default {
        methods: {
            loginUser: function(){
                this.$router.push({ name: 'login' })
            }
        },
        router
    }
</script>