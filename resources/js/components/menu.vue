
<template>

    <v-app >
        <v-layout row>
        <v-flex xs12 sm6 offset-sm3>
            <v-card>
            <v-img :src="imgSrc"  height="200px" ></v-img>
    
            <v-card-title primary-title>
                    <div class="headline"> {{ name }}</div> 
            </v-card-title>
    
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn icon @click="show = !show">
                <v-icon>{{ show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
                </v-btn>
            </v-card-actions>
    
            <v-slide-y-transition>
                <v-card-text v-show="show">
                    {{ description }} 
                </v-card-text>
            </v-slide-y-transition>
            </v-card>
        </v-flex>
        </v-layout>
    </v-app>
</template>
<!--
<template>
    <div id="app">
    <v-app id="inspire">
        <v-data-table :headers="headers" :items="desserts" class="elevation-1">
        <template slot="items" slot-scope="props">
            <td>{{ props.item.name }}</td>
            <td class="text-xs-right">{{ props.item.calories }}</td>
            <td class="text-xs-right">{{ props.item.fat }}</td>
            <td class="text-xs-right">{{ props.item.carbs }}</td>
            <td class="text-xs-right">{{ props.item.protein }}</td>
            <td class="text-xs-right">{{ props.item.iron }}</td>
        </template>
        </v-data-table>
    </v-app>
    </div>
</template>
-->
<script type="text/javascript">    
    export default {
        data () {
            return {
                name: '',
                type: '',
                description: '',
                price: '',
                imgSrc: '',
                show: false,
                menu: []
            }
        },mounted () {
            axios.get('/api/menu').then(response =>(
                //this.menu = response.data,
                response.data.data.forEach(element => {
                    this.name = element.name,
                    this.type = element.type,
                    this.description = element.description,
                    this.imgSrc = element.photo_url,
                    console.log(element.photo_url),
                    this.price = element.price
                })
            ))
        }
    }
</script>