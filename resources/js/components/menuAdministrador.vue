<template>
    <div >
        <v-navigation-drawer stateless value="true" >
            <v-toolbar flat class="transparent" >
                <v-list class="pa-0">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img src="https://randomuser.me/api/portraits/men/85.jpg" >
                        </v-list-tile-avatar>
                        <v-list-tile-title>John Leider</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-toolbar>

            
            <v-list class="pt-0" dense>
                <v-list-group no-action>
                    <v-list-tile slot="activator"> 
                        <v-list-tile-action>
                            <v-icon>restaurant</v-icon>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>Definições</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <router-link to="/profile-user">
                        <v-list-tile @click=""  >
                            <v-list-tile-content>
                                <v-list class="text-lg-left">Change Profile</v-list>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link to="/profile-user">
                        <v-list-tile @click=""  >
                            <v-list-tile-content>
                                <v-list class="text-lg-left">Change Profile</v-list>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>

                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <router-view></router-view>
    </div>
</template>

<script>
  export default {
    props: ['title'],
    data () {
      return {
        items: [
        ]
      }
    },
      methods: {
            procura(e) {
                this.$router.push({name: 'profile-user'})
            }
      }
  }
</script>
