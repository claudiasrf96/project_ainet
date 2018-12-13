<template>
  <v-data-table :headers="headers" :items="orders" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems" >
    <template  slot="items" slot-scope="props" >
      <td>{{ props.item.responsible_cook_id }}</td>
      <td>{{ props.item.state }}</td>
      <td @class=" true ? 'red'  : 'blue'"  class="text-xs-left">{{ props.item.created_at }}</td>
      <td @class=" false ? 'red'  : 'blue'" class="text-xs-left">{{ props.item.updated_at }}</td>
      <td class="text-xs-left">{{ props.item.item_id }}</td>
      <td class="text-xs-left">{{ props.item.meal_id }}</td>
      <td class="text-xs-left">{{ props.item.start }}</td>
      <td class="text-xs-left">{{ props.item.end }}</td>
      <td class="text-xs-left">
        <v-btn :disabled=" props.item.state != 'in preparation'" primary hide-details @click="markAsPrepared(props.item)">Prepared</v-btn>
        <v-btn :disabled="props.item.state !=  'pending'"  primary hide-details @click="markAsInPreparation(props.item)">In preparation</v-btn> 
      </td>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    props: ['user', 'onlyActiveOrders'],
    data () {
      return {
        orders: [],
        pagination: {
          descending: true,
          page: 1,
          rowsPerPage: 7,
          sortBy: 'created_at', // todo
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
          { text: 'Data Criação', value: 'created_at' },
          { text: 'Ultima Atualização', value: 'updated_at' },
          { text: 'Id do Produto', value: 'item_id' },
          { text: 'Id da Refeição', value: 'meal_id' },
          { text: 'Ordered Date', value: 'start' },
          { text: 'Deliver Date', value: 'end' },
          { text: 'Ação', sortable: false },
        ],
      }
    },
    mounted () {
      this.getOrders();
    },
    methods: {
      getOrders() {
            axios.get('api/order') .then(response=>{
              let data = response.data.data;
              if(this.onlyActiveOrders){
                this.orders = data.filter(a => a.state == 'prepared');
              }else{
                this.orders = data;
              }
            }); 
      },
      markAsPrepared(e){
        console.log(e);
            e.state = 'prepared';
            axios.post('/api/order/update/' + e.id, e).then(response => {  
            })
      },
      markAsInPreparation(e){
            e.state = 'in preparation';
            axios.post('/api/order/update/' + e.id, e).then(response => {  
          })
      },
      
      
  }
}
</script>
<style>

</style>