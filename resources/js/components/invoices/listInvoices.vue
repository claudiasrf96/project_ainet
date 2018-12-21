<template>
    <div>
    <v-data-table :headers="headers" :items="invoice" :pagination.sync="this.pagination" :total-items="totalInvoices"  >
      <template slot="items" slot-scope="props">  
        <td >{{ props.item.id  }}</td>
        <td class="text-xs-left">{{ props.item.state }}</td>
        <td class="text-xs-left">{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.nif }}</td>
        <td class="text-xs-left">{{ props.item.total_price }}</td>
        <td class="text-xs-left">{{ props.item.date }}</td>
      </template>
    </v-data-table>
  </div>
</template>


<script>
  export default {
    data () {
      return{
        invoice: [],
        totalInvoices: 0,
        pagination: {},
        headers: [
            {
                text: 'Id',
                align: 'rigth',
                value: 'id'
            },
            { text: 'Estado', value: 'state' },
            { text: 'Nome do Cliente', value: 'name' },
            { text: 'Nif do Cliente', value: 'nif' },
            { text: 'Preço total', value: 'total_price' },
            { text: 'Data', value: 'date'  },
        ],
      }
    },
    watch: {
      pagination: {
        handler () {
          this.getInvoices().then(data => {
              this.invoice = data.items
              this.totalInvoices = data.total
            })
        },
      }
    },
    mounted () {
      this.getInvoices().then(data => {
          this.invoice = data.items
          this.totalInvoices = data.total
        })
        
        this.getInvoices()
    },
    methods:{
      getInvoices() {
         // axios.get('api/invoice').then(response=>{ invoice/pending
            axios.get('api/invoice/pending').then(response=>{   
                this.invoice = response.data.data;
            });
        },
    }
}
</script>