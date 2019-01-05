<template>
  <v-data-table :headers="headers" :items="orders" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems" >
    <template  slot="items" slot-scope="props" >
      <td class="text-xs-left">{{ props.item.id }}</td>
      <td :class="props.item.state == 'delivered' ? 'red' : 'blue'">{{ props.item.state }}</td>
      <td class="text-xs-left"> {{ props.item.responsible_cook_name }}</td>
      <td class="text-xs-left">{{ props.item.start }}</td>
      <td class="text-xs-left">{{ props.item.end }}</td>
      <td class="text-xs-left">{{ props.item.item_id }}</td>
      <td class="text-xs-left">{{ props.item.meal_id }}</td>
      <td class="text-xs-left">
        <v-btn :disabled=" props.item.state != 'in preparation'" primary hide-details @click="markAsPrepared(props.item)">Prepared</v-btn>
        <v-btn :disabled="props.item.state !=  'pending'"  primary hide-details @click="markAsInPreparation(props.item)">In preparation</v-btn> 
        <v-btn :disabled="props.item.state !=  'pending'" flat primary hide-details @click="deletOrder(props.item)"><v-icon>cancel_presentation</v-icon></v-btn>
        <v-btn primary hide-details @click="markAsDeliverd(props.item)">Deliverd</v-btn>
      </td>
    </template>
  </v-data-table>
</template>

<script>


  export default {
    props: ['new_order', 'listState'],
    data () {
      return {
        orders: [],
				changeType: "",
				tempStyleUser: null,
        pagination: {
          descending: true,
          page: 1,
          rowsPerPage: 7,
          sortBy: 'created_at', // todo
          rowsPerPageItems: [7, 15, 30]
        },
        headers: [
          {
            text: 'ID',
            align: 'rigth',
            sortable: false,
            value: 'id'
          },
          {
            text: 'Estado das Refeições',
            align: 'rigth',
            sortable: false,
            value: 'state'
          },
          {
            text: 'Cozinheiro Responsavel',
            align: 'rigth',
            sortable: false,
            value: 'responsible_cook_name'
          },
          { text: 'Ordered Date', value: 'start' },
          { text: 'Deliver Date', value: 'end' },
          { text: 'Id do Produto', sortable: false  },
          { text: 'Id da Refeição' , sortable: false  },
          { text: 'Ação', sortable: false },
        ],
      }
    },
    mounted () {
      this.getUserInfor();
      this.getOrders();
    },
    watch: { 
      new_order: function(newVal, oldVal){
          this.orders.push(newVal);
      },
      listState: function(newVal, oldVal){
        this.getOrders(); 
      }
    },
    
    methods: {
        getOrders() {
          if(this.listState == 'cook'){
              axios.get('api/order/getPendingConfirmed/' + this.user.id).then(response=>{
                this.orders = response.data.data;
                console.log(this.orders);
              });
          }else if(this.listState == 'waiter'){
              axios.get('api/order/getPreparedOrders/'+ this.user.id).then(response=>{
                let data = response.data.data;
                this.orders = data;
              });
          }else{
            axios.get('api/order').then(response=>{
                let data = response.data.data;
                this.orders = data;
              });
          }
        },
        markAsPrepared(e){
          console.log(e);
              e.state = 'prepared';
                axios.put('api/order/updateState/'+ e.id, e).then(response => {  
                  this.$socket.emit('order_changed', e, "Prepared");
              })
        },
        markAsInPreparation(e){
            e.state = 'in preparation';
              axios.put('api/order/updateState/' + e.id, e).then(response => { 
                this.$socket.emit('order_changed', e, "Being Prepared");
            })
        },
        deletOrder(e){
            const index = this.orders.indexOf(e);
            this.orders.splice(index, 1);
            axios.delete('api/order/delete/' + e.id).then(response=> {
                this.$socket.emit('order_deleted', e, "Deleted");
            });
        },
        markAsDeliverd(e){
            e.state = 'delivered';
            axios.put('api/order/updateState/' + e.id, e).then(response => {
              this.$socket.emit('order_changed', e, "Delivered");
            }),
            setTimeout(() =>
                this.orders.splice(this.orders.indexOf(e), 1)
            ,2500);
        },
        getUserInfor() {
              this.user = this.$store.state.user;
        },
        makePagination(page) {
            axios.get('api/order?page='+ page).then(response =>(
                this.orders = response.data.data,
                this.curenntPage = response.data.meta.current_page,
                this.pagination = response.data.link,
                this.lastPage = response.data.meta.lastPage
            ))
        },
        changeStyleTemp: function(orderAlterada,index, type, time_ms){
            this.orders[index].state = orderAlterada.state;
            setTimeout( () => {
              this.changeType = "";
              this.tempStyleOrder = null;
            }, time_ms)
          },
      },
      sockets: {
        order_changed(changedOrder){
          let index = this.orders.findIndex(x => x.id === changedOrder[0].id);
          if (index !== null) {
            this.changeStyleTemp(changedOrder[0] ,index, changedOrder[1], 3000);
          }          
        },     
        order_deleted(deletedOrder){
          let index = this.orders.findIndex(x => x.id === deletedOrder[0].id);
          this.orders.splice(index , 1);     
        },        	
      },
}
</script>
<style>

</style>