<template>
  <form >
    <v-container grid-list-md>
        <v-layout wrap>
            <v-flex xs12 sm6 md6>
                <v-text-field v-model="selectMeal" disabled solo label="Id da Refeição" required></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field  v-model="selectDish" disabled solo label="Prato"  required ></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field v-model="selectDrink" disabled solo label="Bebida"  required ></v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12 class="text-xs-center">
                <v-btn style="min-width: 500px" round color="primary" dark @click="createMeal">Criar Prato</v-btn>
            </v-flex>
        </v-layout>
    </v-container>
  </form>
</template>


<script>
  export default {
    props: ['orderinfo'],
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
       /* this.getMenuItems();
        this.getMeals();*/
    },

    watch: { 
        orderinfo: function(newVal, oldVal){
            this.selectMeal = newVal.selected_meal;
            this.selectDish = newVal.selected_drink;
            this.selectDrink = newVal.selected_dish;
        },
    },
    methods: {
       /* getMeals() {
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
        },*/
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