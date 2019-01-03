<template>
    <v-layout  v-show="create_user" align-start justify-end row fill-height class="layoutSpace" >
        <v-flex class="insertCard">
                <v-slide-y-transition >
                    <v-card >
                        <form >
                            <v-container grid-list-md > <!-- d-flex -->
                               <!-- <v-flex  xs2 sm2 md2 justify-center style="margin-top: 40%">
                                    <v-btn icon @click="show = !show"><v-icon>{{ show ? 'arrow_forward_ios' : 'arrow_back_ios' }}</v-icon></v-btn>
                                </v-flex> 
                                <v-flex xs10 sm10 md10>-->
                                <v-flex >
                                    <v-text-field solo  v-model="user.name" :counter="20" label="Username" required></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-text-field solo  v-model="user.username" :counter="20" label="Name" required ></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-text-field solo  v-model="user.email" :counter="20" label="Email   " required ></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-select solo  v-model="select" :items="items"  label="Item" required ></v-select>
                                </v-flex>
                                <v-flex >
                                    <v-btn block  round color="primary" dark @click="submit">Adicionar Utilizador</v-btn>
                                </v-flex>
                                <v-flex>
                                    <v-btn  block  round color="primary" dark @click="clear">Clear</v-btn>
                                </v-flex>
                            </v-container>
                        </form>
                    </v-card>
                </v-slide-y-transition>
            </v-flex>
    </v-layout>
</template>



<script>
  export default {
    props: ['create_user'],
    data: () => ({
      user: {
            name:"",
            username:"",
            password: "",
            email: "",
            type: ""
      },
      show: false,
      select: null,
      items: [
        'Manager',
        'Waiter',
        'Cook',
        'Cashier'
      ]
    }),
    mounted() { 
    },
    computed: {
    
    },
    methods: {
      submit () {   
          this.select = this.select.toLowerCase();
          this.user.type = this.select;
          console.log(this.user);
          axios.post('/api/users/createUser', this.user)
                .then(function (response) {
                })
                .catch(function (error) {
                    console.log(error);
                });
      },
      clear () {
        this.user.name = ''
        this.user.username = ''
        this.user.email = ''
        this.select = null
      },
    }
  }
</script>
<style>

@media screen and (min-width: 1000px) {
    .insertCard{
        position: fixed;
        z-index: 100;
        min-width: 550px;
    }
    .layoutSpace{
        margin: 0px !important;
    }
}
</style>