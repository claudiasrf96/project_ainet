<template>
    <v-container  justify-center  xs12>
        <v-flex xs7 align-center offset-xs2  justify-center>
            <form>
                <v-text-field v-model.lazy="user.name" :counter="20" label="Name" required ></v-text-field>
                <v-text-field v-model.lazy="user.username" :counter="20" label="Username" required></v-text-field>

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
          user: []
      }
    },
    mounted() {
       this.getUserInfor();    
    },
    methods: {
        clear () {
            this.name = ''
            this.username = ''
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
