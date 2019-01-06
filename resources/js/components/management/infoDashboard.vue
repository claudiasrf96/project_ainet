<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" :height="imgHeight">
            <v-layout column fill-height>
                <v-card-title class="white--text pl-5 pt-5 titleText">
                    <div class="display-1 pl-5 pt-5">Invoices / Meals / Orders</div>
                </v-card-title>
            </v-layout>
    </v-parallax>
    <v-card>
        <v-toolbar color="teal" dark>
          <v-toolbar-title>Invoices</v-toolbar-title>
        </v-toolbar>
    </v-card>
    <list-invoices :dashboard="true" ></list-invoices>
    <br>
    <br>
    <br>
    <v-card>
        <v-toolbar color="teal" dark>
          <v-toolbar-title >Meals and Respective Orders</v-toolbar-title>
        </v-toolbar>
    </v-card>
    <order-details :dashboard="true"></order-details>
</div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false,
            imgHeight: "250",
            show: false,
            
        }
    },
    methods: {
      togleImgHeigh(){
        this.imgHeight = this.imgHeight == "250" ? "500" : "250"; 
      }
    }
  }
</script>

<style lang="less">
.titleText{
    text-shadow: 1px 1px black; 
}
</style>
