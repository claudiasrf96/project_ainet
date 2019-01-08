<template>
  <v-data-table :headers="headers" :items="orders" item-key="id" :pagination.sync="pagination" :total-items="totalOrders" :rows-per-page-items="pagination.rowsPerPageItems" >
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
        totalOrders: 0,
        type: "",
        pagination: {
            page: 1,
            rowsPerPage: 7,
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
      this.type = this.listState;
      this.getUserInfor();
    },
    watch: { 
      new_order: function(newVal, oldVal){
          this.orders.push();
      },
      listState: function(newVal, oldVal){
        this.type = newVal;
        this.getOrders(); 
      },
      pagination: {
          handler () {
              this.getOrders().then(data => {
                  this.orders = data.items
                  this.totalOrders = data.total
              })
          },
          deep: true
      }
    },
    
    methods: {
        getOrders() {
          return new Promise((resolve, reject) => {
            if(this.type == 'cook'){
                axios.get('api/order/confirmed/inPreparation/cook/' + this.user.id + '?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{
                    let items = response.data.data;
                    let total = response.data.meta.total;
                    resolve({
                        items,
                        total
                    })
                });
            }else if(this.type == 'waiterPendingConfirmed'){
                axios.get('api/order/pending/confirmed/waiter/' + this.user.id + '?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{
                  let items = response.data.data;
                  let total = response.data.meta.total;
                  resolve({
                      items,
                      total
                  })
                });
            }else if(this.type == 'waiter'){
                axios.get('api/order/getPreparedOrders/' + this.user.id + '?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{
                  let items = response.data.data;
                  let total = response.data.meta.total;
                  resolve({
                      items,
                      total
                  })
                });
            } else{
              axios.get('api/order' + '?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{
                  let items = response.data.data;
                  let total = response.data.meta.total;
              
                  resolve({
                      items,
                      total
                  })
                });
              }
          });
        },
        markAsPrepared(e){
          console.log(e);
              e.state = 'prepared';
                axios.put('api/order/updateState/'+ e.id, e).then(response => {  
                  this.$socket.emit('order_cook', 'Prepared', 'list-orders', e);
                  this.$socket.emit('order_state_waiter', 'Prepared', 'list-orders',e);
              })
        },
        markAsInPreparation(e){
            e.state = 'in preparation';
              axios.put('api/order/updateState/' + e.id, e).then(response => { 
                  this.$socket.emit('order_cook', 'In preparation', 'list-orders',  e);
                  this.$socket.emit('order_state_waiter', 'In preparation', 'list-orders',e);
            })
        },
        deletOrder(e){
            const index = this.orders.indexOf(e);
            this.orders.splice(index, 1);
            axios.delete('api/order/delete/' + e.id).then(response=> {
            });
        },
        markAsDeliverd(e){
            e.state = 'delivered';
            axios.put('api/order/updateState/' + e.id, e).then(response => {
                  this.$socket.emit('order_cook', 'Delivered', 'list-orders',  e);
                  this.$socket.emit('order_state_waiter', 'Delivered', 'list-orders', e);
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
        order_cook(dataFromServer){
            this.getOrders();
        },
        order_state_waiter(dataFromServer){
            this.getOrders();
        },       
        /*order_deleted(deletedOrder){
          let index = this.orders.findIndex(x => x.id === deletedOrder[0].id);
          this.orders.splice(index , 1);     
        }, */       	
      },
}
</script>
<style>

</style>