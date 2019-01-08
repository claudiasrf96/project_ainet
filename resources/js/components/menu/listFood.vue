<template>
  <div>
    <v-data-table :headers="headers" :items="food" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems"  >
      <template slot="items" slot-scope="props">  
        <v-avatar :tile="true"  :size="80" color="grey lighten-4">
            <v-img :src="'storage/items/' + props.item.photo_url" :lazy-src="'storage/items/' + props.item.photo_url" aspect-ratio="2"  contain class="grey lighten-2"></v-img>
        </v-avatar>
        <td class="text-xs-left" :class="props.item.selected == '1' ? 'green' : '' ">{{ props.item.name  }}</td>
        <td class="text-xs-left">{{ props.item.price  }}</td>
        <td class="justify-left layout px-0">
            <v-btn round color="blue" :disabled="notSelected" style="margin-top: 20px;" @click="adicionarItem(props.item); notSelected = !notSelected; props.item.selected = '1' ">  Aicionar &emsp; <v-icon dark>done</v-icon></v-btn>
        </td>
      </template>
    </v-data-table>
  </div>
</template>


<script>
  export default {
    props: ['type'],
    data () {
      return {
        food: [],
        notSelected: false,
        pagination: {
          descending: true,
          page: 1,
          rowsPerPage: 7,
          rowsPerPageItems: [7, 15, 30]
        },
        headers: [
          {
            text: 'Photo',
            align: 'rigth',
            sortable: false,
            value: 'photo_url'
          },
          {
            text: 'Nome',
            align: 'rigth',
            sortable: false,
            value: 'name'
          },
          { text: 'Price', value: 'price' },
          {  sortable: false},
        ],
      }
    },
    mounted () {
      this.getFood();
    },    
    methods: {
        getFood() {
            if(this.type == 'dish'){
                axios.get('api/menu/dishs').then(response=>{
                    this.food = response.data.data;
                });
            }else if(this.type == 'drink'){
                axios.get('api/menu/drinks').then(response=>{
                    this.food = response.data.data;
                });
            }
        },
        adicionarItem(item){
            
            if(this.type == 'dish'){
                this.$emit('selected_dish', item);
            }else if(this.type == 'drink'){
                this.$emit('selected_drink', item);
            };
        }
    }
}
</script>
