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
          
               <v-data-iterator :items="items"  content-tag="v-layout" row wrap>
                 <v-flex slot="item" slot-scope="props" xs12 sm6 md4  lg3 >
                  <v-card>
                    <v-list dense>
                      <v-list-tile>
                            <v-chip  v-model="chip1"  close >{{  props.item.id }} </v-chip>
                      </v-list-tile>
                    </v-list>
                  </v-card>
                 </v-flex>
              </v-data-iterator>


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
        chip1: true,
        items: [],
      }
    },
    mounted(){
      this.getUsers();
    },
    methods: {  
        sendGlobalMsg: function(){
            if (this.$store.state.user === null) {
                this.$socket.emit('msg_from_client', this.msgGlobalText);
            } else {
              console.log(this.$store.state.user.type = 'manager' );
             //   this.$socket.emit('msg_from_client_dep',this.msgGlobalText,this.$store.state.user);
                this.$socket.emit('msg_from_client', this.msgGlobalText,
                this.$store.state.user);
            }
            this.msgGlobalText = "";
        },
         getUsers() {
                axios.get('api/user').then(response=>{
                    this.items = response.data.data;
                    
                console.log(this.items )
                });
            },
     },
      sockets:{   
        connect(){
            console.log('socket connected (socket ID = '+this.$socket.id+')');
        },
        msg_from_server(dataFromServer){

        }, 
      }
  }
</script>
<style>

.boxLeft{
  min-height: 700px;
  border-left: 1px solid black
}
</style>