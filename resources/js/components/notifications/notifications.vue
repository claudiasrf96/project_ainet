<template>
  <v-form ref="form" @submit.prevent="submit">
    <v-container grid-list-xl fluid>
      <v-layout wrap>
        <v-flex xs9>
          <v-textarea color="teal" id="inputGlobal" v-model="msgGlobalText" >
            <div slot="label">
              asd  
            </div>
          </v-textarea>
          <v-btn @click.prevent="sendGlobalMsg">Send</v-btn>
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
        msgGlobalText: "",
        msgGlobalTextArea: "",
      }
    },
     methods: {  
        sendGlobalMsg: function(){
            if (this.$store.state.user === null) {
                this.$socket.emit('msg_from_client', this.msgGlobalText);
            } else {
                this.$socket.emit('msg_from_client', this.msgGlobalText,
                this.$store.state.user);
            }
            this.msgGlobalText = "";
        },
    },
  }
</script>
<style>

.boxLeft{
  min-height: 700px;
  border-left: 1px solid black
}
</style>