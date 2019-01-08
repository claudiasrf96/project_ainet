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
            <v-btn round color="orange" :disabled="props.item.blocked == 1"  @click="blockUser(props.item); props.item.blocked = 1">  Block  &emsp; <v-icon dark>done</v-icon></v-btn>
            <v-btn round color="green" :disabled="props.item.blocked == 0"  @click="unblockUser(props.item); props.item.blocked = 0">  Unblock  &emsp; <v-icon dark>done</v-icon></v-btn>
            <v-btn round color="red"   @click="deleteUser(props.item); ">  Delete  &emsp; <v-icon dark>done</v-icon></v-btn>
            <v-btn round color="primary" :disabled="props.expanded"  style="float: left;"  @click="props.expanded = !props.expanded"> Editar  &emsp; <v-icon dark >edit</v-icon></v-btn>
        </td>        
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
        <template slot="expand"  slot-scope="props" >
            <v-card flat >
                <v-form ref="form"  lazy-validation>
                        <v-layout style="margin: 0px;" justify-center >
                        <v-flex xs12 sm3 md3>
                            <v-text-field v-model="props.item.name" label="Nome"  required  ></v-text-field> <!-- :rules="emailRules" -->
                        </v-flex>
                        <v-flex xs12 sm3 md3>
                            <v-text-field v-model="props.item.username" label="Username"  required ></v-text-field> <!-- :rules="emailRules" -->
                        </v-flex>
                        <v-flex xs12 sm3 md3>
                            <v-text-field v-model="props.item.email" label="Nif"  required ></v-text-field> <!-- :rules="emailRules" -->
                        </v-flex>
                        <v-flex xs12 sm3 md3 s>
                            <v-btn round color="green" style="margin-top: 20px;" dark hide-details @click="alterarUtilizador(props.item); props.expanded = !props.expanded">  Confirmar  &emsp; <v-icon dark>done</v-icon></v-btn>
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
            blockUser(user){
                axios.put('api/user/blockUser/' + user.id ).then(response=>{
                    //this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            unblockUser(user){
                axios.put('api/user/unblockUser/' + user.id).then(response=>{
                    //this.users = response.data.data;
                    console.log(this.users); 
                });
            },
            alterarUtilizador(user){
                axios.put('/api/users/update/user/' + user.id, user).then(response => {  
                    console.log(response.data.data);
                })
                .catch(function(err) {
                    console.log(err);
                });
            },
            deleteUser(user){
                axios.put('api/user/deleteUser/' + user.id).then(response=>{
                    //this.users = response.data.data;
                    console.log(this.users); 
                });
            }
        }
    }
</script>



