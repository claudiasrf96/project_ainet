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

    const menu = Vue.component('menu-user', require('./menu/menu.vue'));
    const login = Vue.component('login-user', require('./login/loginUser.vue'));
    const logout = Vue.component('logout-user', require('./login/logoutUser.vue'));
    const admin = Vue.component('menu-admin', require('./menuAdministrador.vue'));
    const profile = Vue.component('profile-user', require('./profile/profileUser.vue'));
    const change_password = Vue.component('change-password-user', require('./profile/changePassword.vue'));
    const create = Vue.component('create-user', require('./profile/createNewUser.vue'));
    const change_profile = Vue.component('change-profile-user', require('./profile/changeProfile.vue'));
    const create_meal = Vue.component('create-meal', require('./meals/createNewMeal.vue'));
    const list_meals = Vue.component('list-meals', require('./meals/listMeals.vue'));
    const from_meals = Vue.component('form-meals', require('./meals/formMeals.vue'));
    const list_order = Vue.component('list-orders', require('./orders/listOrders.vue')); 
    
    const list_food = Vue.component('list-food', require('./menu/listFood.vue'));

    const create_order = Vue.component('create-orders', require('./orders/createNewOrders.vue'));
    //const from_order = Vue.component('form-order', require('./orders/formOrders.vue')); 
    const order_details = Vue.component('order-details', require('./orders/orderDetails.vue'));
    
    
    const fill_invoices = Vue.component('fill-invoices', require('./invoices/fillInvoice.vue'));
    const list_invoices = Vue.component('list-invoices', require('./invoices/listInvoices.vue'));


    const details_invoices = Vue.component('details-invoices', require('./invoices/invoiceDetails.vue')); 

    
    //const details_manager_invoices = Vue.component('details-manager-invoices', require('./invoices/listInvoiceDetailedManager.vue')); 
    
    const manager_dasbord = Vue.component('manager-dasboard', require('./management/managerDashboard.vue'));
    
    const manager_info_dashboard = Vue.component('manager-info-dashboard', require('./management/infoDashboard.vue'));

    
    const list_users = Vue.component('list-users', require('./management/listUsers.vue'));

    const list_tables = Vue.component('list-tables', require('./tables/listTables.vue'));

    const form_user = Vue.component('form-user', require('./management/formUser.vue'));
    
    const form_food = Vue.component('form-food', require('./menu/formFood.vue'));
    
    const notification = Vue.component('notification-user', require('./notifications/notifications.vue')); 


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
          path: '/create-orders',
          component: create_order,
          name: 'create-orders'
        },
        {
          path: '/list-orders/:listState',
          component: list_order,
          name: 'list-orders',
          props: true
        },
        {
          path: '/list-food',
          component: list_food,
          name: 'list-food',
          props: true
        },
         {
          path: '/list-meals',
          component: list_meals,
          name: 'list-meals',
        },
        {
          path: '/notification-user',
          component: notification,
          name: 'notification-user'
        },
        {
          path: '/order-details',
          component: order_details,
          name: 'order-details'
        },
         {
          path: '/list-invoices',
          component: list_invoices,
          name: 'list-invoices'
        },
        {
          path: '/list-tables',
          component: list_tables,
          name: 'list-tables'
        },
         {
          path: '/details-invoices',
          component: details_invoices,
          name: 'details-invoices'
        },
        /*{
          path: '/details-manager-invoices',
          component: details_manager_invoices,
          name: 'details-manager-invoices'
        },*/
        {
          path: '/fill-invoices',
          component: fill_invoices,
          name: 'fill-invoices'
        },
        {
          path: '/manager-dasbord',
          component: manager_dasbord,
          name: 'manager-dasbord'
        },
        {
          path: '/list-users',
          component: list_users,
          name: 'list-users'
        },
        {
          path: '/form-user',
          component: form_user,
          name: 'form-user'
        },
        {
          path: '/form-food',
          component: form_food,
          name: 'form-food'
        },
        {
          path: '/manager-info-dashboard',
          component: manager_info_dashboard,
          name: 'manager-info-dashboard'
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

<style>

@media screen and (min-width: 1000px) {
    .insertCard{
        position: fixed;
        z-index: 100;
        min-width: 550px;
        border: 2px;
        border-style: solid;
        border-color: grey;
        bottom:0;
        right:0;
    }
    .layoutSpace{
        margin: 0px !important;
    }
}

.upload-btn-wrapper {
  position: relative;
  overflow: hidden;    
  text-align: center;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 20px 40px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style><style>