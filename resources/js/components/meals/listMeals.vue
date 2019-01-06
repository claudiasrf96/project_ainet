<template>
  <div>
    <v-data-table :headers="headers" :items="meals" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
      <template slot="items" slot-scope="props">  
        <td :class="props.item.selected == '1' ? 'green' : '' ">{{ props.item ? props.item.state : "" }}</td>
        <td class="text-xs-left">{{ props.item ? props.item.table_number : ""}}</td>
        <td class="text-xs-left">{{ props.item ? props.item.start : ""}}</td>
        <td class="text-xs-left">{{ props.item ? props.item.user_table_name: "" }}</td>
        <td class="text-xs-left">{{ props.item ?  props.item.total_price_preview : ""}}</td>
        <td class="justify-left layout px-0">
             <v-btn round color="blue" v-if="creating_meal == true" :disabled="notSelected" @click="adicionarItem(props.item); notSelected = !notSelected; props.item.selected = '1' ">  Aicionar &emsp; <v-icon dark>done</v-icon></v-btn>
             <v-btn round color="blue" v-else :disabled="notSelected" @click="terminateMeal(props.item);">  Terminate &emsp; <v-icon dark>done</v-icon></v-btn>    
        </td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
    export default {
        props: ['new_meal', 'creating_meal'],
        data () {
            return {
                meals: [],
                notSelected: false,
                pagination: {
                    descending: true,
                    page: 1,
                    rowsPerPage: 7,
                    sortBy: 'created_at',
                    rowsPerPageItems: [7, 15, 30]
                },
                headers: [
                    {
                        text: 'Estado das Refeições',
                        align: 'rigth',
                        sortable: false,
                        value: 'state'
                    },
                    { text: 'Numero da Mesa', value: 'table_number' },
                    { text: 'Ordered Date', value: 'start' },
                    { text: 'Responsavel', value: 'responsible_waiter_id' },
                    { text: 'Preço', value: 'total_price_preview' },
                    { text: 'Ação', sortable: false },
                ],
            }
        },
        mounted () {
            this.getUserInfor();
            this.getMeals();
        },
        watch: { //quand altera execut
            new_meal: function(newVal, oldVal){
                this.meals.push(newVal);
            }
        },

        methods: {
            getMeals() {
                if(this.creating_meal == true){
                    //getActiveMealWithOpenOrder
                    axios.get('api/meal/getActiveMeal/' + this.user.id).then(response=>{
                        
                        this.meals = response.data.data;
                        console.log(this.meals); 
                    }); 
                }else{

                    axios.get('api/meal').then(response=>{
                        
                        this.meals = response.data.data;
                        console.log(this.meals); 
                    });
                }
            },
            close () {
                this.dialog = false
                setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                this.desserts.push(this.editedItem)
                }
                this.close()
            },
            terminateMeal(item){
                let index = this.meals.indexOf(item);
                item.state = 'terminated';
                axios.put('api/meal/update/' + item.id, item).then(response=>{  
                    this.meals.splice(index , 1);
                    response.data.data.orders.forEach(function(entry) {
                        entry.state = "not delivered";
                        axios.put('api/order/updateState/' + entry.id, entry).then(response => {  
                            console.log("Order Not Delivered"); //Todo
                        });
                    });
                    
                }); 
            },
            getUserInfor() {
                this.user = this.$store.state.user;
            },

            changeStyleTemp: function(orderAlterada, type, time_ms){
                this.meals.push(orderAlterada);
                setTimeout( () => {
                this.changeType = "";
                this.tempStyleOrder = null;
                }, time_ms)
            },
            adicionarItem(item){
                this.$emit('selected_meal', item);
            },
      },
      sockets: {
        meal_created(createdMeal){
            this.changeStyleTemp(createdMeal[0], createdMeal[1], 3000); 
        },  	
      },
}
</script>