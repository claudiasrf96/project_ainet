
<template>
    <v-app >
        <v-layout align-center row wrap xs12>
            <v-flex xs3  v-for="menu in menus" v-bind:key = "menu.id">
                <v-card @click="selectedId = menu" >
                    <v-img :src="'storage/items/' + menu.photo_url"  height="200px" ></v-img>
            
                    <v-card-title primary-title>
                            <div class="headline">
                                <p> {{ menu.name }}</p>
                                <h3 class="price"> {{ menu.price }}</h3>
                            </div>
                    </v-card-title>
                </v-card>
                <div class="text-xs-center">
                    <v-dialog v-model="selectedId" width="500">
                        <v-card> 
                            <v-card-title class="headline grey lighten-2" primary-title>
                                {{ menu.name }}
                            </v-card-title>

                            <v-card-text>
                                {{ menu.description }}
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </div>
            </v-flex>
        </v-layout>
       
        <div class="text-xs-center">
            <v-pagination v-model="curenntPage" :length="6" @input="makePagination"> </v-pagination>
        </div>
        

    </v-app>

    
</template>

<script type="text/javascript">    
    export default {
        data () {
            return {
                menus: [],
                curenntPage: 1,
                pagination: [],
                selectedId: "",
                lastPage: Number
            }
        },created () {
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
            }
        },
        computed: {
            show() {
                return this.post.id === this.selectedId
            },
        },
    }
</script>

<style>

.price{
    align-content: left;
}
</style>