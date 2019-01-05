<template> 
    <v-container grid-list-md text-xs-center fluid>
      <v-layout>
            <v-flex fill-height xs2>
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
                    <router-link to="/notification-user">
                        <v-btn flat  block>
                            <v-icon v-if="true" color="grey" class="v-list__tile__action">notifications</v-icon>
                            <v-icon color="rgba(242, 38, 19, 1)" v-else>notifications_active</v-icon>
                            <v-list-tile-title class="v-list__tile__content" >Notificações</v-list-tile-title>
                        </v-btn>
                    </router-link>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>fastfood</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Pedido</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link  to='/create-orders'>
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Criar novo Pedido</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link :to="{ name: 'list-orders', params: { listState: 'cook' }}">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Pedidos (PH: COOK)</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link :to="{ name: 'list-orders', params: { listState: 'waiter' }}">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Pedidos (PH: WAITER)</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link to="/order-details">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Orders (PH: WAITER)</v-list>
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
                                    <v-list-tile-title>Refeição</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link to="/create-meal">
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Criar nova Refeição</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    </v-list>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>library_books</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Invoices</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <router-link to="/fill-invoices" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Lista de Invoices</v-list>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link to="/details-invoices" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Detalhes sobre Invoices</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                            <router-link to="/details-manager-invoices" >
                                <v-list-tile @click=""  >
                                    <v-list-tile-content>
                                        <v-list class="text-lg-left">Detalhes sobre Invoices (PH: Admin)</v-list> 
                                    </v-list-tile-content>
                                </v-list-tile>
                            </router-link>
                        </v-list-group>
                    </v-list>
                    <v-list class="pt-0" dense >
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
                        
                    <v-btn flat block @click="sendNotification">
                            <v-icon >message</v-icon>
                    </v-btn>
                </v-navigation-drawer>
            </v-flex>
            <v-flex xs10>
                <router-view ></router-view>
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
            sendNotification(){
                
            }
      }
  }
</script>
