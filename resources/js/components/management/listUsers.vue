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
        <td class="text-xs-left">
            <v-btn round color="orange"  dark hide-details @click="blockUser(props.item); props.expanded = !props.expanded">  Block  &emsp; <v-icon dark>done</v-icon></v-btn>
            <v-btn round color="green"  dark hide-details @click="unblockUser(props.item); props.expanded = !props.expanded">  Unblock  &emsp; <v-icon dark>done</v-icon></v-btn>
            <v-btn round color="red"  dark hide-details @click="deleteUser(props.item); props.expanded = !props.expanded">  Delete  &emsp; <v-icon dark>done</v-icon></v-btn>
        </td>        
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
                { sortable: false },
                ]
            }
        },
        mounted () {
            this.getUserInfor();
            this.getUsers();
        },
        methods: {
            getUsers() {
                axios.get('api/user').then(response=>{
                    
                    this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            getUserInfor() {
                this.user = this.$store.state.user;
            },
            blockUser(){
                axios.get('api/user/block').then(response=>{
                    this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            unblockUser(){
                axios.get('api/user/unblock').then(response=>{
                    this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            deleteUser(){
                axios.get('api/user/delete').then(response=>{
                    this.users = response.data.data;
                    console.log(this.users); 
                });
            }
        }
    }
</script>



