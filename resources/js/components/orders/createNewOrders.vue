<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" height="250">
            <form-order v-show="isActive" @new_order="getNewOrder"></form-order>
            <v-btn color="error" round large absolute right @click="isActive = !isActive">
                Add new Item &nbsp;&nbsp;
                <v-icon>playlist_add</v-icon>
            </v-btn>
    </v-parallax>
    <list-orders :new_order="new_order"></list-orders>
</div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false,
            new_order: ''
        }
    },
    methods: {
        getNewOrder(val){
            this.new_order = val;
        }
    }
  }
</script>