<template>
    <v-layout  v-show="editing_food" align-start justify-end row fill-height class="layoutSpace" >
        <v-flex class="insertCard">
                <v-slide-y-transition >
                    <v-card >
                        <form >
                            <v-container grid-list-md > <!-- d-flex -->
                               <!-- <v-flex  xs2 sm2 md2 justify-center style="margin-top: 40%">
                                    <v-btn icon @click="show = !show"><v-icon>{{ show ? 'arrow_forward_ios' : 'arrow_back_ios' }}</v-icon></v-btn>
                                </v-flex> 
                                <v-flex xs10 sm10 md10>-->
                                <v-btn absolute color="red" class="white--text" fab  right top @click="emitClose">
                                    <v-icon>close</v-icon>
                                </v-btn>
                                <v-flex class="upload-btn-wrapper"  >
                                    <button class="btn">Atualizar Imagem</button>
                                    <input type="file" id="file" ref="file" name="myfile"  v-on:change="handleFileUpload()"/>
                                </v-flex>
                                <v-flex >
                                    <v-text-field solo  v-model="editingItem.name" :counter="20" label="Nome" required></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-text-field solo  v-model="editingItem.price" :counter="20" label="Preço" required ></v-text-field>
                                </v-flex>
                                <v-flex >
                                     <v-textarea  v-model="editingItem.description" solo name="input-7-4" label="Descrição" ></v-textarea>
                                </v-flex>
                                <v-flex >
                                    <v-btn block  round color="primary" dark @click="submit">Atualizar Item</v-btn>
                                </v-flex>
                                <v-flex>
                                    <v-btn  block  round color="primary" dark @click="clear">Reset</v-btn>
                                </v-flex>
                            </v-container>
                        </form>
                    </v-card>
                </v-slide-y-transition>
            </v-flex>
    </v-layout>
</template>



<script>
  export default {
    props: ['editing_food', 'selected_item'],
    data: () => ({
      
      show: false,
      select: null,
      items: [
        'Manager',
        'Waiter',
        'Cook',
        'Cashier'
      ],
      editingItem: {}
    }),
    mounted() { 
        
    },
    computed: {
    
    },
    watch: { 
      selected_item: function(newVal, oldVal){
          this.editingItem = newVal;
      },
    },
    methods: {
      submit () {  
        
        axios.put('api/menu/update/' + this.selected_item.id, this.editingItem)
            .then(response => {
               // this.$emit('updatedItem', response.data.data);
            })
            .catch(function (error) {
            });
      },
      clear () {
            this.editingItem = this.selected_item;
      },
      emitClose(){
        this.$emit('closeEdit');
      }
    }
  }
</script>
<style>

@media screen and (min-width: 1000px) {
    .insertCard{
        position: fixed;
        z-index: 100;
        min-width: 550px;
        border: 2px;
        border-style: solid;
        border-color: grey;
        bottom:0;
        right:0;
    }
    .layoutSpace{
        margin: 0px !important;
    }
}

</style>