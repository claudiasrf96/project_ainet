<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" height="250">
            <form-order v-show="isActive"></form-order>
    </v-parallax>
    <list-invoices ></list-invoices> 
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
    }//:new_order="new_order"  @new_order="getNewOrder">
  }
</script>