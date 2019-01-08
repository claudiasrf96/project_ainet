<template>
    <div >
        <v-parallax :src="'storage/banners/refeicao-2.jpg'" height="250">
        </v-parallax>
        <list-orders :new_order="new_order"></list-orders>
        <v-container grid-list-md >
            <v-layout wrap>
                <v-flex xs12 sm6 md6> 
                    <list-food @selected_dish="addDish" :type="'dish'"></list-food>
                </v-flex>
                <v-flex xs12 sm6 md6> 
                    <list-food @selected_drink="addDrink" :type="'drink'"></list-food>
                </v-flex>
                <v-flex xs12 sm12 md12>
                    <list-meals @selected_meal="addOrder" :create_order="true" ></list-meals>
                </v-flex>
            </v-layout>
        </v-container>
        <template>
        <v-layout  v-show="order.selected_dish.id != '' && order.selected_drink.id != '' && order.selected_meal.id != '' " align-start justify-end row fill-height class="layoutSpace" >
            <v-flex class="insertCard">
                    <v-slide-y-transition >
                        <v-card >
                            <form >
                                <v-flex xs12 sm12 md12>
                                    <v-text-field v-model="order.selected_meal.id" disabled solo label="Id da Refeição" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field  v-model="order.selected_dish.name" disabled solo label="Prato"  required ></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field v-model="order.selected_drink.name" disabled solo label="Bebida"  required ></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-btn block  round color="primary" dark @click="submit">Criar order</v-btn>
                                </v-flex>
                            </form>
                        </v-card>
                    </v-slide-y-transition>
                    </v-flex>
            </v-layout>
        </template>
    </div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false,
            new_order: '',
            order: {
                selected_dish: {
                    id: "",
                    name: ""
                },
                selected_drink: {
                    id: "",
                    name: ""},
                selected_meal: {
                    id: ""}
            }
        }
    },
    mounted(){
        this.getUserInfo();
        console.log(this.order)
    },
    methods: {
        addDish(e){
            this.order.selected_dish = e;
        },
        addDrink(e){
            this.order.selected_drink = e;
        },
        addOrder(e){
            this.order.selected_meal = e;
        },
        submit() {
            this.order.state = 'pending';
            this.order.responsible_cook_id = "";
            this.order.meal_id =  this.order.selected_meal.id;
            this.order.item_id = this.order.selected_dish.id;

            this.$socket.emit('order_cook', 'Created', 'create-orders', this.order);
            this.$socket.emit('order_cook', 'Created', 'create-meal', this.order);
            axios.post('api/order/createOrder', this.order).then(response => {
                this.new_order = responser.data.data;
                this.order.item_id =this.order.selected_meal.id;

           
            }).catch(function (error) {
                console.log(error);
            });

            this.$socket.emit('order_cook', 'Created', 'create-orders', this.order);
            this.$socket.emit('order_cook', 'Created', 'create-meal', this.order);
            axios.post('api/order/createOrder', this.order).then(response => {
                this.new_order = responser.data.data;
            }).catch(function (error) {
                console.log(error);
            });
           
        },
        getUserInfo() {
            this.user = this.$store.state.user;
        },
    },
  }
</script>