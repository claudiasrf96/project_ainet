<template>
  <div>
    <v-data-table :headers="headers" :items="meals" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
      <template slot="items" slot-scope="props">  
        <td >{{ props.item ? props.item.state : "" }}</td>
        <td class="text-xs-left">{{ props.item ? props.item.table_number : ""}}</td>
        <td class="text-xs-left">{{ props.item ? props.item.start : ""}}</td>
        <td class="text-xs-left">{{ props.item ? props.item.user_table_name: "" }}</td>
        <td class="text-xs-left">{{ props.item ?  props.item.total_price_preview : ""}}</td>
        <td class="justify-left layout px-0">
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="deleteItem(props.item)" >delete</v-icon>
        </td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
    export default {
        props: ['new_meal'],
        data () {
            return {
                meals: [],
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
              /*  axios.get('api/meal/getActiveMealWithOpenOrder/' + this.user.id).then(response=>{
                    
                    this.meals = response.data.data;
                    console.log(this.meals); 
                }); 
              */  axios.get('api/meal').then(response=>{
                    
                    this.meals = response.data.data;
                    console.log(this.meals); 
                });
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
            getUserInfor() {
                this.user = this.$store.state.user;
            },
        }
    }
</script>