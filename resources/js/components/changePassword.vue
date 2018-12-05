<template>
    <v-container  justify-center  xs12>
        <v-flex xs7 align-center offset-xs2  justify-center>
            <form>
                <v-text-field :type="'password'" v-model.lazy="user.password" :counter="10" label="Password" required ></v-text-field>
                <v-text-field :type="'password'" v-model.lazy="newPassword"  :counter="10" label="Nova Password" required></v-text-field>
                <v-text-field :type="'password'" v-model.lazy="newPasswordConf"  :counter="10" label="Confirmar a nova Password" required></v-text-field>

                <v-btn @click="changeUser">submit</v-btn>
                <v-btn @click="clear">clear</v-btn>
            </form>
        </v-flex>
    </v-container>
</template>
<script>

export default {
    data () {
      return {
          user: [],
          newPassword: '',
          newPasswordConf: '',
      }
    },
    mounted() {
       this.getUserInfor();    
    },
    methods: {
        clear () {
            this.user.password = ''
            this.newPassword = ''
            this.newPasswordConf = ''
        },
        changeUser(){
            axios.put('/api/users/' + this.user.id, this.user).then(response => {  
                this.$store.commit('setUser',response.data.data);
            })
            .catch(function(err) {
                console.log(err);
            });
        }, 
        getUserInfor() {
            this.user = this.$store.state.user;
        }
    }
}
</script>