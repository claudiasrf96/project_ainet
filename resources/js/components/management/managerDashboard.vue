<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" :height="imgHeight">
      <v-btn color="error" round large absolute right @click="isActive = !isActive; show = !show" >
          Add new Item &nbsp;&nbsp;
          <v-icon>playlist_add</v-icon>
      </v-btn>    
    </v-parallax>
    <list-users :create_user="show" ></list-users> 
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