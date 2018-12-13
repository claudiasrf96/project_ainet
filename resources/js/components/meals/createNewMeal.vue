<template>
    <div>
        <v-parallax :src="'storage/banners/meals.jpg'" height="250"> 
            <form-meals v-show="isActive" ></form-meals>
            <v-btn color="error" round large absolute right @click="isActive = !isActive">
                Add new Item &nbsp;&nbsp;
                <v-icon>playlist_add</v-icon>
            </v-btn>
        </v-parallax>
        <list-meals></list-meals>
    </div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false
        }
    },
    methods: {

    }

  }
</script>
