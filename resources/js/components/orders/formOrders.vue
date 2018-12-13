<template>
  <form >
    <v-container grid-list-md>
        <v-layout wrap>
            <v-flex xs10 sm5 md5>
                <v-select :items="meals" v-model="selectMeal" solo label="Id da Refeição" required></v-select>
            </v-flex>
            <v-flex xs10 sm5 md5>
            </v-flex>
            <v-flex xs10 sm5 md5>
                <v-select :items="dishes" v-model="selectDish" solo label="Prato"  required ></v-select>
            </v-flex>
            <v-flex xs10 sm5 md5>
                <v-select :items="drinks" v-model="selectDrink" solo label="Bebida"  required ></v-select>
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
            user: [],
            selectMeal: "",
            selectDish: "",
            selectDrink: "",
            dishes:  [],
            drinks: [],
            meals: [],
            order: {}
        }
    },
     mounted () {
        this.getMeals();
        this.getMenuItems();
        this.getUserInfor();
    }
    ,
    methods: {
        getMeals() {
            axios.get('api/meal').then(response=>{
                let data = response.data.data;
                let filterData = data.filter(a => a.state  == 'active');
                this.meals = filterData.map(a => a.id);
                console.log(this.meals);
            }); 
        },
        getMenuItems() {
            axios.get('api/menu').then(response=>{
                let data = response.data.data;
                let filterData = data.filter(a => a.type  == 'dish');
                this.dishes = filterData.map(a => "Id: " + a.id + " (" + a.name + ")");
                filterData = data.filter(a => a.type  == 'drink');
                this.drinks = filterData.map(a => "Id: " + a.id + " (" + a.name + ")");
            }); 
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        createMeal() {
            this.order.item_id = selectDish;
            this.order.meal_id = selectMeal; //perguntar como meter isto na bD XD //todo
            axios.post('/api/order/createOrder', this.meal)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
  }
</script>