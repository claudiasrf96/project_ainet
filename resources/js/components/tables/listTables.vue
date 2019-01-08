<template>
        <v-container grid-list-md > 
            <v-layout wrap>
                <v-flex xs12 sm12 md12>
                    <v-data-table :headers="headers" :items="tables" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
                        <template slot="items" slot-scope="props">  
                            <td :class="props.item.selected == '1' ? 'green' : '' ">{{ props.item.table_number }}</td>
                            <td class="text-xs-left">{{ props.item.created_at  }}</td>
                            <td class="text-xs-left">{{ props.item.deleted_at == null ? 'No' : props.item.deleted_at  }}</td>
                            
                            <td class="justify-left layout px-0">
                                <v-btn round color="blue" :disabled="notSelected" @click="adicionarItem(props.item); notSelected = !notSelected; props.item.selected = '1' ">  Aicionar &emsp; <v-icon dark>done</v-icon></v-btn>         
                            </td>
                        </template>
                    </v-data-table>
                </v-flex>
            </v-layout>
        </v-container>
</template>
<script>
  export default {
    data () {
        return{
            tables: [],
            notSelected: false,
            pagination: {
                    descending: true,
                    page: 1,
                    rowsPerPage: 7,
                    sortBy: 'id',
                    rowsPerPageItems: [7, 15, 30]
                },
                headers: [
                    {
                        text: 'Id',
                        align: 'rigth',
                        sortable: false,
                        value: 'id'
                    },
                    { text: 'Date of adicion', value: 'created_at', sortable: false },
                    { text: 'Deleted', value: 'deleted_at', sortable: false },
                    {  sortable: false  },
                ],
        }
    }, 
    mounted () {
      this.getTables();
    },
    methods: {
        getTables() {
            axios.get('api/table').then(response=>{
                console.log(response.data.data);
                this.tables = response.data.data;
                //meal.map(a => a.table_number);
            }); 
        },
        adicionarItem(item){
            this.$emit('selected_table', item)
        }
       
    }
}
</script>