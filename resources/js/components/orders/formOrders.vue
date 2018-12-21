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
        this.getUserInfo();
        this.getMenuItems();
        this.getMeals();
    }
    ,
    methods: {
        getMeals() {
            console.log(this.user.id);
            axios.get('api/meal/getActiveMeal/' + this.user.id ).then(response=>{
                let filterData = response.data.data
                this.meals = filterData.map(a => a.id);
            }); 
        },
        getMenuItems() {
            axios.get('api/menu').then(response=>{ //todo
                let data = response.data.data;
                let filterData = data.filter(a => a.type  == 'dish');
                this.dishes = filterData.map(a => "Id: " + a.id + " (" + a.name + ")");
                filterData = data.filter(a => a.type  == 'drink');
                this.drinks = filterData.map(a => "Id: " + a.id + " (" + a.name + ")");
            }); 
        },
        getUserInfo() {
            this.user = this.$store.state.user;
        },
        createMeal() {
            this.order.state = 'pending';
            this.order.responsible_cook_id = this.user.id;
            this.order.meal_id = this.selectMeal;
            this.order.item_id = this.selectDish.substring(4, 6).trim();
            axios.post('/api/order/createOrder', this.order)
                .then(response => {
                    this.$emit('new_order', response.data.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.order.item_id = this.selectDrink.substring(4, 6).trim();
            axios.post('/api/order/createOrder', this.order)
                .then(response => {
                    this.$emit('new_order', response.data.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
  }
</script>