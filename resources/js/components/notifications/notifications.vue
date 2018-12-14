<template>
  <v-form ref="form" @submit.prevent="submit">
    <v-container grid-list-xl fluid>
      <v-layout wrap>
        <v-flex xs9>
          <v-textarea  color="teal"   id="inputGlobal" v-model="msgGlobalText" @keypress.enter="sendGlobalMsg" >
            <div slot="label">
              asd  
            </div>
          </v-textarea>
        </v-flex>
        <v-flex xs3 class="boxLeft">
        </v-flex>
      </v-layout>
    </v-container>   
  </v-form>
</template>


<script>
  export default {
    data () {
      return{

      }
    }
  }
</script>
<style>

.boxLeft{
  min-height: 700px;
  border-left: 1px solid black
}
</style>