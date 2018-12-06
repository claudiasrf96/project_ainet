<template>
    <v-container  justify-center  xs12>
        <v-flex xs7 align-center offset-xs2  justify-center>
            <form>
                <v-text-field v-model="user.name" :counter="20" label="Username" required></v-text-field>
                <v-text-field v-model="user.username" :counter="20" label="Name" required ></v-text-field>
                <v-text-field v-model="user.email" :counter="20" label="Name" required ></v-text-field>

                <v-select v-model="select" :items="items"  label="Item" required ></v-select>

                <v-btn @click="submit">Submit</v-btn>
                <v-btn @click="clear">Clear</v-btn>
            </form>
        </v-flex>
    </v-container>
</template>


<script>
  
  export default {
   
    data: () => ({
      user: {
            name:"",
            username:"",
            password: "",
            email: "",
            items: ""
      },
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
          axios.post('/api/users/createUser', this.user)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
      },
      clear () {
        this.name = ''
        this.username = ''
        this.email = ''
        this.select = null
      },
    }
  }
</script>