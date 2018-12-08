<template>
  <v-data-table :headers="headers" :items="meals" class="elevation-1" >
    <template slot="items" slot-scope="props">
      <td>{{ props.item.state }}</td>
      <td @class=" true ? 'red'  : 'blue'"  class="text-xs-left">{{ props.item.table_number }}</td>
      <td @class=" false ? 'red'  : 'blue'" class="text-xs-left">{{ props.item.total_price_preview }}</td>
      <td class="text-xs-left">{{ props.item.start }}</td>
      <td class="text-xs-left">{{ props.item.end }}</td>
      <td class="text-xs-left">{{ props.item.responsible_waiter_id }}</td>
      <td class="text-xs-left">
        <v-btn :disabled="props.item.state == 'terminated' || 'prepared'" v-model="props.selected" primary hide-details @click="markAsPrepared(props.item.id)">Prepared</v-btn>
        <v-btn :disabled="props.item.state == 'terminated' || 'in preparation'" v-model="props.selected" primary hide-details @click="markAsInPreparation(props.item.id)">In preparation</v-btn>
      </td>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    props: ['user'],
    data () {
      return {
        meals: [],
        headers: [
          {
            text: 'Estado das Refeições',
            align: 'rigth',
            sortable: false,
            value: 'meals.state'
          },
          { text: 'Table Number', value: 'table_number' },
          { text: 'Price', value: 'total_price_preview' },
          { text: 'Ordered Date', value: 'start' },
          { text: 'Deliver Date', value: 'end' },
          { text: 'Responsible Waiter', value: 'responsible_waiter_id' },
          { text: 'Ação', sortable: false },
        ]
      }
    },
    mounted () {
      this.getMeals();
    },
    methods: {
      getMeals() {
           axios.get('api/meals') .then(response=>{
              this.meals = response.data.data; 
              console.log(response.data.data.total_price_preview);
            });
      },
      markAsPrepared(e){
          console.log(e);
      },
      markAsInPreparation(e){
          console.log(e);
      },
      
      
  }
}
</script>
<style>

</style>