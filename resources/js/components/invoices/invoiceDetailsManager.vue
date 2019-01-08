<template>
<v-data-table :headers="headers" :items="invoice" item-key="id" :pagination.sync="pagination" :total-items="totalInvoices" :rows-per-page-items="pagination.rowsPerPageItems" >
  <template  slot="items" slot-scope="props" >
        <tr @click="props.expanded = !props.expanded">
            <td >{{ props.item.sate }}</td>
            <td class="text-xs-left">{{ props.item.date }}</td>
            <td class="text-xs-left">{{ props.item.meals.users.name}}</td>
            <td class="text-xs-left">{{ props.item.meals.total_price_preview }}</td>
            <td class="text-xs-left"> <v-icon>expand_more</v-icon></td>
        </tr>
    </template>
    <template slot="expand" slot-scope="props">
      <v-card class="orderTable">
        <v-data-table :headers="headers2" :items="props.item.invoice_item" item-key="id" >
            <template  slot="items" slot-scope="props" >
                <td >{{ props.item.quantity}}</td>
                <td class="text-xs-left"> {{ props.item.items.name }}</td>
                <td class="text-xs-left">{{ props.item.items.price }}</td>
                <td class="text-xs-left">{{ props.item.sub_total_price }}</td>
                <td>
                 <v-btn round color="primary" style="float: left;" dark primary hide-details @click="downloadItem(props.item)" > <a> Download </a>  &emsp; <v-icon dark >edit</v-icon></v-btn>
                </td>
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
            invoice: [],
            totalInvoices: 0,
            pagination: {
                page: 1,
                rowsPerPage: 7,
                rowsPerPageItems: [7, 15, 30]
            },
            headers: [
                {
                    text: 'Data',
                    align: 'rigth',
                    sortable: false,
                    value: 'date'
                },
                { text: 'Numero da Mesa', value: 'table_number', sortable: false },
                { text: 'Empregado Responsavel', value: 'name', sortable: false },
                { text: 'Preço Total (Preview)', value: 'total_price_preview', sortable: false },
                { text: 'Drop Down', sortable: false },
            ],
            headers2: [
                {
                    text: 'Quantidade',
                    align: 'rigth',
                    sortable: false,
                    value: 'quantity'
                },
                { text: 'Nome Item', value: 'name' },
                { text: 'Preço Unitario', value: 'price' },
                { text: 'Sub Total', value: 'sub_total_price' },
            ],
            
        }
    },
    mounted () {
      this.getUserInfor();
    },
    watch: {
        pagination: {
            handler () {
                this.getPage().then(data => {
                    this.invoice = data.items
                    this.totalInvoices = data.total
                })
            },
            deep: true
        }
    },
    methods: {
        getPage(page){ 
            return new Promise((resolve, reject) => {
            axios.get('api/invoice/invoiceInfo?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{  
                let items = response.data.data;
                let total = response.data.meta.total;
            
                resolve({
                    items,
                    total
                })
                });
            })
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        downloadItem(item){
            axios.get('api/manager/pdf/' + item.item_id).then(response => {
            });
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
