<template> 
    <v-container grid-list-md text-xs-center fluid>
      <v-layout>
            <v-flex fill-height xs12 sm2 md2>
                <v-navigation-drawer stateless value="true"  >
                    <router-link to="/profile-user"  style="text-decoration : none">
                        <v-toolbar flat class="transparent" >
                                <v-list class="pa-0">
                                    <v-list-tile avatar>
                                        <v-list-tile-avatar v-show="user.photo_url != null">
                                            <img :src="'storage/profiles/' + user.photo_url" >
                                        </v-list-tile-avatar>
                                        <v-list-tile-title > {{user.username}} </v-list-tile-title>
                                        <v-icon color="rgba(173,255,47 ,1)" v-if= "user.shift_active == 1" >done</v-icon>
                                        <v-icon color="rgba(242, 38, 19, 1)" v-else >clear</v-icon>
                                    </v-list-tile>
                                </v-list>
                        </v-toolbar>
                    </router-link>
                    <router-link to="/send-notification">
                        <v-btn flat block>
                            <v-icon >message</v-icon>
                        </v-btn>
                    </router-link>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>fastfood</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Order</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link  to='/create-orders'>
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Criar novo Order</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link v-if="getUserType() == 'cook'" :to="{ name: 'list-orders', params: { listState: 'cook' }}">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list  class="text-lg-left" >Lista de Orders </v-list> <!-- (PH: COOK US9) -->
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link  v-if="getUserType() == 'waiter'" :to="{ name: 'list-orders', params: { listState: 'waiter' }}">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Orders </v-list> <!-- (PH: WAITER US17)  14 / 17-->
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link  v-if="getUserType() == 'waiter'" :to="{ name: 'list-orders', params: { listState: 'waiterPendingConfirmed' }}">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista das minhas Orders </v-list>  <!-- (PH: WAITER US14)  “pending” or “confirmed”/prepared” --> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link  v-if="getUserType() == 'waiter'" to="/order-details">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista Detalhada de Orders </v-list>  <!-- (PH: WAITER US14)-->
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>local_dining</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Meals</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link v-if="getUserType() == 'waiter'" to="/create-meal">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left" >Criar nova Meals</v-list> <!-- (PH: WAITER US12) -->
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                             <router-link  v-if="getUserType() == 'waiter'" to="/list-meals">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Meals</v-list> <!-- (PH: WAITER US21) -->
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    </v-list>
                    <v-list v-if="getUserType() == 'cashier' || getUserType() == 'manager'" class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>library_books</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Invoices</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link  v-if="getUserType() == 'cashier'" :to="{ name: 'fill-invoices', params: { typeInvoice: 'filingInvoice' }}" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Invoice</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link  v-if="getUserType() == 'manager'" to="/list-meals" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">List All Invoice</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link  v-if="getUserType() == 'cashier' || getUserType() == 'cashier'" :to="{ name: 'fill-invoices', params: { typeInvoice: 'downloadInvoice' }}" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista Paid Invoices To Download</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link v-if="getUserType() == 'cashier'" to="/details-invoices" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Detalhes sobre Invoices</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link v-if="getUserType() == 'manager'" to="/list-invoices-details-manager" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Detalhes sobre Invoices Manager</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    <v-list v-if="getUserType() == 'manager'" class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>people</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Managment</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link to="/manager-dasbord">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">List users</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link to="/manager-info-dashboard">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Info Dasboard (PH: Admin) 30</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>settings</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Definições</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link to="/change-profile-user">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Change Profile</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link to="/change-password-user">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Change Password</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    <v-btn v-if="user.shift_active == 0" flat block @click="checkShift">Enter Shift</v-btn>
                    <v-btn v-else flat block @click="checkShift">Leave Shift</v-btn>
                </v-navigation-drawer>
                <notification-user></notification-user>
            </v-flex>
            <v-flex xs12 sm10 md10>
                <router-view  @updatedPhoto="updatedPhoto"></router-view>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  export default {
    data () {
      return {
        user: [],
        pendingConfirmed: "pendingConfirmed",
        prepared: "prepared"
      }
    },
    mounted() {
       this.getUserInfor();
    },
      methods: {
            procura(e) {
                this.$router.push({name: 'profile-user'})
            },
            getUserInfor() {
                this.user = this.$store.state.user;
            },
            getUserType(){
                return this.user.type;
            },
            checkShift() {
                this.user.shift_active = this.user.shift_active == 1 ? 0 : 1;
                if(this.user.shift_active == 0){
                    this.user.last_shift_end = this.getCurrentDate();
                }else{
                    this.user.last_shift_start = this.getCurrentDate();
                }
                axios.put('/api/users/updateShift/' + this.user.id, this.user).then(response => {
                    this.$store.commit('setUser',response.data.data);
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getCurrentDate() {
                let d =  new Date();
                return d.getFullYear() + "-" + (d.getMonth() + 1)  + "-" + (d.getDay() +2) + " " +d.getHours() + ":" +d.getMinutes() + ":" +d.getSeconds();
            },
            updatedPhoto(photo){
                this.user.photo_url = photo;
            }
        },
        sockets:{   
            connect(){
                console.log("ola");
                if(this.$store.state.user !== null){

                    this.$socket.emit('user_enter', this.$store.state.user);
                }
            },
        }
  }
</script>
