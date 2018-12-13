<template>
  <div>
    <v-data-table :headers="headers" :items="meals" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
      <template slot="items" slot-scope="props">
        <td >{{ props.item.state }}</td>
        <td class="text-xs-left">{{ props.item.table_number }}</td>
        <td class="text-xs-left">{{ props.item.start }}</td>
        <td class="text-xs-left">{{ props.item.responsible_waiter_id }}</td>
        <td class="text-xs-left">{{ props.item.total_price_preview }}</td>
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
            this.getMeals();
        },
        methods: {
            getMeals() {
                axios.get('api/meal').then(response=>{
                    this.meals = response.data.data; 
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
            }
        }
    }
</script>