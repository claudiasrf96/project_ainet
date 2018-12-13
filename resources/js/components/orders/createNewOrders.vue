<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" height="250">
            <form-order v-show="isActive"></form-order>
            <v-btn color="error" round large absolute right @click="isActive = !isActive">
                Add new Item &nbsp;&nbsp;
                <v-icon>playlist_add</v-icon>
            </v-btn>
    </v-parallax>
    <list-orders :onlyActiveOrders="true"></list-orders>
</div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false
        }
    }
  }
</script>