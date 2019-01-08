<template>
<div >
    <v-parallax :src="'storage/banners/refeicao-2.jpg'" height="250">
    </v-parallax>
    <list-invoices :typeInvoice='tipoDeInvoice'></list-invoices> 
</div>
</template>

<script>
  export default {
    props: ['typeInvoice'],
    data () {
        return{
            isActive: false,
            new_order: '',
            tipoDeInvoice: ''
        }
    },
    mounted(){
        this.tipoDeInvoice = this.typeInvoice;
    },
    watch: {
       typeInvoice: function(newVal, oldVal){
          this.tipoDeInvoice = newVal;
      },
    },
    methods: {
        getNewOrder(val){
            this.new_order = val;
        }
    }
  }
</script>