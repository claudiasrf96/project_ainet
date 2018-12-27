<template>
 
  <div>
    <form-user :create_user="create_user" ></form-user>
    <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    
    <v-data-table :headers="headers" :items="users" :pagination.sync="pagination" :rows-per-page-items="pagination.rowsPerPageItems" 
      :search="search"  >
        
      <template slot="items" slot-scope="props">  
         <v-avatar :tile="true"  :size="80" color="grey lighten-4">
            <v-img :src="'storage/profiles/' + props.item.photo_url" :lazy-src="'storage/profiles/' + props.item.photo_url" aspect-ratio="2"  contain class="grey lighten-2"></v-img>
        </v-avatar>     
        <td class="text-xs-left">{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.username }}</td>
        <td class="text-xs-left">{{ props.item.email }}</td> 
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </div>
</template>

<script>
    export default {
        props: ['create_user'],
        data () {
            return{
                search: '',
                show: '',
                user: {},
                users: [],
                totalInvoices: 0,
                pagination: {
                    rowsPerPageItems: [7, 15, 30]
                },
                headers: [
                    
                { text: 'Foto',  align: 'rigth', sortable: false },
                {
                    text: 'Nome',
                    value: 'name',
                    sortable: false,
                    width: "30%"
                },
                { text: 'Username', value: 'username', sortable: false },
                { text: 'Email', value: 'email', sortable: false },
                ]
            }
        },
        mounted () {
            this.getUserInfor();
            this.getMeals();
        },
        methods: {
            getMeals() {
                axios.get('api/user').then(response=>{
                    
                    this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            getUserInfor() {
                this.user = this.$store.state.user;
            },
        }
    }
</script>



