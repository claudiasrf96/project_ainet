<template>
<v-data-table :headers="headers" :items="meals" item-key="id" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
  <template  slot="items" slot-scope="props" >
        <tr @click="props.expanded = !props.expanded">
            <td >{{ props.item ? props.item.state : "" }}</td>
            <td class="text-xs-left">{{ props.item ? props.item.table_number : ""}}</td>
            <td class="text-xs-left">{{ props.item ? props.item.start : ""}}</td>
            <td class="text-xs-left">{{ props.item ? props.item.responsible_waiter_id: "" }}</td>
            <td class="text-xs-left">{{ props.item ?  props.item.total_price_preview : ""}}</td>
            
            <td > <v-icon>expand_more</v-icon></td>
        </tr>
    </template>
    <template slot="expand" slot-scope="props">
      <v-card class="orderTable">
        <v-data-table :headers="headers2" :items="props.item.orders" item-key="id" >
            <template  slot="items" slot-scope="props" >
                <td >{{ props.item.state}}</td>
                <td class="text-xs-left"> {{ props.item.users.name }}</td>
                <td class="text-xs-left">{{ props.item.items.name }}</td>
            </template>
        </v-data-table>
      </v-card>
    </template>
  </v-data-table>
</template>




<script>
  export default {
    data () {
        return{
            orders: [],
            meals: [],
            pagination: {
                descending: true,
                page: 1,
                rowsPerPage: 7,
                sortBy: 'created_at', // todo
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
            headers2: [
                {
                    text: 'Estado das Orders',
                    align: 'rigth',
                    sortable: false,
                    value: 'state'
                },
                { text: 'Cuzinheiro Responsavel', value: 'responsible_cook_id' },
                { text: 'Item Id', value: 'item_id' },
            ],
            
        }
    },
    mounted () {
      this.getUserInfor();
      this.getMeals();
    },
    methods: {
        getMeals(){
            axios.get('/api/meal').then(response=>{
                console.log(response.data.data);
                this.meals = response.data.data;
            });
        },
        getOrders() {
            axios.get('/api/order/getOrderDetails/' + this.user.id).then(response=>{
                console.log(response.data.data);
            });
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
    }
}
</script>
<style>
    .orderTable{
        border: 1px solid;
        box-shadow: 1px 1px #888888;
    }
</style>
