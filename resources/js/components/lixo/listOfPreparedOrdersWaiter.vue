<template>
  <v-data-table :headers="headers" :items="orders" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems" >
    <template  slot="items" slot-scope="props" >
      <td>{{ props.item.responsible_cook_id }}</td>
      <td>{{ props.item.state }}</td>
      <td class="text-xs-left">{{ props.item.start }}</td>
      <td class="text-xs-left">{{ props.item.end }}</td>
      <td class="text-xs-left">{{ props.item.item_id }}</td>
      <td class="text-xs-left">{{ props.item.meal_id }}</td>
      <td class="text-xs-left">
        <v-btn primary hide-details @click="markAsDeliverd(props.item)">Deliverd</v-btn>
      </td>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data () {
      return {
        user: [],
        orders: [],
        pagination: {
          descending: true,
          page: 1,
          rowsPerPage: 7,
          sortBy: 'start', // todo
          rowsPerPageItems: [7, 15, 30]
        },
        headers: [
          {
            text: 'Cozinheiro Responsavel',
            align: 'rigth',
            sortable: false,
            value: 'responsible_cook_id'
          },
          {
            text: 'Estado das Refeições',
            align: 'rigth',
            sortable: false,
            value: 'state'
          },
          { text: 'Ordered Date', value: 'start' },
          { text: 'Deliver Date', value: 'end' },
          { text: 'Id do Produto', value: 'item_id' },
          { text: 'Id da Refeição', value: 'meal_id' },
          { text: 'Ação', sortable: false },
        ],
      }
    },
    mounted () {
            this.getUserInfor();
            this.getOrders();
    },
    methods: {
        getOrders() {
            axios.get('api/order/getPreparedOrders/' + this.user.id).then(response=>{
                this.orders = response.data.data;
                //this.orders = data.filter(a =>a.meal_state == 'active');
            }); 
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        markAsDeliverd(e){
            e.state = 'delivered';
            console.log(e);
            axios.put('/api/order/updateState/' + e.id, e).then(response => {
                console.log(response.data.data);
            }),
            setTimeout(() =>
                this.orders.splice(this.orders.indexOf(e), 1)
            ,2500);
        }
    }
  
  }
</script>