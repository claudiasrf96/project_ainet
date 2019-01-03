
<template>
    <div>
       <form-food :editing_food="editing_food" :selected_item="selected_item" ></form-food>
        <v-layout align-center row wrap xs12>
            <v-flex xs3   v-for="menu in menus" v-bind:key = "menu.id">
                
                <v-hover>
                    <v-card @click="selectedId = menu" slot-scope="{ hover }"  class="mx-auto">
                    
                        <v-img :src="'storage/items/' + menu.photo_url"  height="300px"   >
                            
                            <div v-if="hover" class="d-flex darken-2 v-card--reveal white--text" >
                                {{ menu.description }}
                            </div>
                        </v-img>
                
                        <v-card-title primary-title>
                                
                                <v-container grid-list-md d-flex> <!-- d-flex -->
                                    <v-flex xs6>
                                        <h3> {{ menu.name }}</h3>
                                    </v-flex >
                                    <v-flex xs6 >
                                        <h3 class="text-xs-right"> {{ menu.price }}  <v-icon>euro_symbol</v-icon></h3>
                                    </v-flex>
                                </v-container>
                                <v-flex xs12 class="text-xs-right">
                                    <v-btn round color="green" style="margin-top: 20px;" dark hide-details @click="editingFood(); selected_item = menu" >  Editar &emsp; <v-icon dark>edit</v-icon></v-btn>
                                </v-flex>
                        </v-card-title>
                        
                    </v-card>
                </v-hover>
            </v-flex>
        </v-layout>
        <div class="text-xs-center">
            <v-pagination v-model="curenntPage" :length="6" @input="makePagination"> </v-pagination>
        </div>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data () {
            return {
                menus: [],
                curenntPage: 1,
                pagination: [],
                selectedId: "",
                lastPage: Number,
                hover: false,
                editing_food: false,
                selected_item: []
            }
        },
        created () {
            axios.get('/api/menu').then(response =>(
                this.menus = response.data.data,
                this.curenntPage = response.data.meta.current_page,
                this.pagination = response.data.links
            ))
        }, 
        methods: {
            makePagination(page) {
                axios.get('/api/menu?page='+ page).then(response =>(
                    this.menus = response.data.data,
                    this.curenntPage = response.data.meta.current_page,
                    this.pagination = response.data.link,
                    this.lastPage = response.data.meta.lastPage
               ))
            },
            editingFood(){
                if(this.editing_food == false){
                    this.editing_food = !this.editing_food;
                    console.log(this.editing_food);
                }
            }
        },
    }
</script>

<style>

.v-card--reveal {
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 1000;
  opacity: .75;
  background-color: #000000;
  font-size: 20px;
  padding: 25px;
}
</style>