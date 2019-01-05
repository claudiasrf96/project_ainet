<template>
  <form >
    <v-container grid-list-md>
        <v-layout wrap>
            <v-flex xs10 sm5 md5>
                <v-text-field v-model="user.id" disabled solo label="Responsavel"></v-text-field>
            </v-flex>
            <v-flex xs10 sm10 md10>
                <v-select  :items="tables" solo v-model="select"  label="Mesa" required ></v-select>
            </v-flex>
            <v-flex xs10 sm10 md10>
                <v-btn block  round color="primary" dark @click="createMeal">Criar Prato</v-btn>
            </v-flex>
        </v-layout>
    </v-container>
  </form>
</template>

<script>
  export default {
    data () {
        return{
            tables: [],
            user: [],
            select: "",
            meal:  {}
        }
    },
     mounted () {
        this.getTables();
        this.getUserInfor();
    }
    ,
    methods: {
        getTables() {
            axios.get('api/table').then(response=>{
                let meal = response.data.data;
                this.tables = meal.map(a => a.table_number);
            }); 
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        createMeal() {
            this.meal.responsible_waiter_id = this.user.id; 
            this.meal.table_number = this.select; 
            axios.post('/api/meal/createMeal', this.meal)
                .then(response => {
                    this.$socket.emit('meal_created', response.data.data, "Created");
                    this.$emit('newMeal', response.data.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        
    }
  }
</script>