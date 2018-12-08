<template>
    <!--  <v-toolbar-title></v-toolbar-title> -->
    <!--<button @click="loginUser">Login</button>-->
    <!-- <router-link to="/users" class="btn btn-primary"  role="button">Users</router-link>-->
    <v-app>
        <v-toolbar app >
            <v-spacer></v-spacer>
            <v-toolbar-items>
                    <v-btn flat to="/menu-user" >Menu</v-btn>
                    <v-btn v-show="!this.$store.state.user" flat to="/login-user" >Login</v-btn>
                    <v-btn v-show="this.$store.state.user" flat to="/profile-user">Profile</v-btn>
                    <v-btn v-show="this.$store.state.user" flat to="/create-user">Sign In</v-btn>
                    <v-btn v-show="this.$store.state.user" flat to="/logout-user">Logout</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-content fluid>
            <router-view></router-view>
        </v-content>

        <v-footer dark height="auto" >
            <v-card class="flex" flat tile>
                <v-card-title class="teal">
                    <strong class="subheading">Get connected with us on social networks!</strong>
                </v-card-title>
                <v-card-actions class="grey darken-3 justify-center"></v-card-actions>
            </v-card>
        </v-footer>
    </v-app>

    
</template>

<script>
    import VueRouter from 'vue-router';

    const menu = Vue.component('menu-user', require('./menu.vue'));
    const login = Vue.component('login-user', require('./loginUser.vue'));
    const logout = Vue.component('logout-user', require('./logoutUser.vue'));
    const admin = Vue.component('menu-admin', require('./menuAdministrador.vue'));
    const profile = Vue.component('profile-user', require('./profileUser.vue'));
    const change_password = Vue.component('change-password-user', require('./changePassword.vue'));
    const create = Vue.component('create-user', require('./createNewUser.vue'));
    const change_profile = Vue.component('change-profile-user', require('./changeProfile.vue'));
    const create_meal = Vue.component('create-meal', require('./createNewMeal.vue'));
    const list_meal = Vue.component('list-meal', require('./listMeal.vue'));

    const routes = [
    { path: '/', redirect: '/menu-user', name: 'root'},
    { path: '/menu-user', component: menu, name: 'menu'},
    { path: '/login-user', component: login, name: 'login'},
    { path: '/logout-user', component: logout, name: 'logout'},
    { path: '/create-user', component: create, name: 'create'},
    { path: '/menu-admin', component: admin, name: 'admin',
     children: [
        {
          path: '/profile-user',
          component: profile,
          name: 'profile'
        },
        {
          path: '/change-profile-user',
          component: change_profile,
          name: 'change-profile'
        },
        {
          path: '/change-password-user',
          component: change_password,
          name: 'change-password'
        },
         {
          path: '/create-meal',
          component: create_meal,
          name: 'create-meal'
        },
         {
          path: '/list-meal',
          component: list_meal,
          name: 'list-meal'
        },
        
        ]
        },
    ];

    const router = new VueRouter({//cria o componente rotas
        routes:routes
    });    

    export default {data: function(){
		return { 
		        loged: true
			}
		},
        methods: {
            loginUser: function(){
                this.$router.push({ name: 'login' })
            }
        },
        router
    }
</script>