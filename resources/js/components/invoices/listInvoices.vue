<template>
    <div>
    <v-data-table :headers="headers" :items="invoice" item-key="id" :pagination.sync="pagination" :total-items="totalInvoices" :rows-per-page-items="pagination.rowsPerPageItems"   >
      <template slot="items" slot-scope="props">  
        <td >{{ props.item.meals.table_number }}</td>
        <td class="text-xs-left">{{ props.item.state }}</td>
        <td class="text-xs-left">{{ props.item.meals.users.name  }}</td>
        <td class="text-xs-left">{{ props.item.meals.total_price_preview }}</td>
        <v-btn round color="primary" v-if="!props.expanded && emptyCheker(props.item) && updatedInvoice == 0"  style="float: left;" dark primary hide-details @click="props.expanded = !props.expanded"> Concluir  &emsp; <v-icon dark >edit</v-icon></v-btn>
        
        <v-flex xs0 sm10 md10 v-else >
          <v-progress-linear :indeterminate="true" ></v-progress-linear>
        </v-flex>
      </template>
      <template slot="expand"  slot-scope="props" >
        <v-card flat >
          <v-form ref="form" v-model="valid" lazy-validation>
                <v-layout style="margin: 0px;" justify-center >
                  <v-flex xs12 sm3 md3>
                    <v-text-field v-model="props.item.nif" label="Nif"  required  ></v-text-field> <!-- :rules="emailRules" -->
                  </v-flex>
                  <v-flex xs12 sm3 md3>
                    <v-text-field v-model="props.item.name" label="Nome"  required ></v-text-field> <!-- :rules="emailRules" -->
                  </v-flex>
                  <v-flex xs12 sm3 md3 s>
                    <v-btn round color="green" style="margin-top: 20px;" dark hide-details @click="confirmInvoice(props.item.id); props.expanded = !props.expanded">  Confirmar  &emsp; <v-icon dark>done</v-icon></v-btn>
                    <v-btn round color="red" style="margin-top: 20px;" dark hide-details @click="props.expanded = !props.expanded">  Cancelar  &emsp; <v-icon dark>close</v-icon></v-btn>
                  </v-flex>
                </v-layout>
          </v-form>
        </v-card>
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
        nif: [],
        nome: [],
        valid: "",
        updatedInvoice: false,
        pagination: {
          rowsPerPageItems: [7, 15, 30]
        },
        headers: [
            {
                text: 'Numero da Mesa',
                align: 'rigth',
                value: 'table_number',
                sortable: false,
            },
            { text: 'Estado', value: 'state', sortable: false },
            { text: 'Empregado responsavel', value: 'responsible_waiter_id', sortable: false },
            { text: 'Preço total', value: 'total_price_preview', sortable: false },
            { text: 'Ação', sortable: false },
        ],
      }
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
    methods:{
      getPage(page){ 
        return new Promise((resolve, reject) => {
          axios.get('api/invoice?page=' + (this.pagination.page ) + '&page_size=' + this.pagination.rowsPerPage).then(response=>{  
          //   axios.get('api/invoice/pending').then(response=>{ 
            let items = response.data.data;
            let total = response.data.meta.total;
           
            resolve({
              items,
              total
            })
          });
        })
      },
      confirmInvoice(id){
        axios.put('api/invoice/update/' + this.invoice[id -1].id, this.invoice[id -1]).then(response => {  
          this.updatedInvoice = true;
        })
        .catch(function(err) {
          console.log(err);

        });
      },
      emptyCheker(item){
        return (item.nif === "" || item.name === "" );
      }
      
    /*  sockets: {
        invoice_changed(changedInvoice){
          let refToChangedInvoice =  invoice.filter(obj => {return obj === changedInvoice})
          if (refToChangedInvoice !== null) {
            Object.assign(refToChangedInvoice, changedUser);
            //var item = refToChangedInvoice[0];
            //Object.assign(item, changedUser);
            //this.changeStyleTemp(refToChangedUser, "changed", 3000);
        } 
        },       	
      }*/
    }
}
</script>