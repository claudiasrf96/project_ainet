<template> 
    <v-container grid-list-md text-xs-center fluid>
      <v-layout>
            <v-flex fill-height xs2>
                <v-navigation-drawer stateless value="true"  >
                    <router-link to="/profile-user"  style="text-decoration : none">
                        <v-toolbar flat class="transparent" >
                                <v-list class="pa-0">
                                    <v-list-tile avatar>
                                        <v-list-tile-avatar>
                                            <img src="https://randomuser.me/api/portraits/men/85.jpg" >
                                        </v-list-tile-avatar>
                                        <v-list-tile-title > {{user.username}} </v-list-tile-title>
                                        <v-icon color="rgba(173,255,47 ,1)" >done</v-icon>
                                    </v-list-tile>
                                </v-list>
                        </v-toolbar>
                    </router-link>
                    <v-list class="pt-0" dense >
                        <v-list-group no-action>
                            <v-list-tile slot="activator"> 
                                <v-list-tile-action>
                                    <v-icon>restaurant</v-icon>
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
        user: {
            name: "",
            username: ""
        }
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
                console.log(this.$store.state.user);
            }
      }
  }
</script>
