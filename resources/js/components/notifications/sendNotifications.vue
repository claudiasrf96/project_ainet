
 <template>
  <v-form ref="form" @submit.prevent="submit">
        <v-flex v-if="user.type == 'manager'">
          <v-textarea color="teal" id="msgToManager" disabled v-model="message"  >
              <div slot="label">
                Message Receive From  {{ }}   
              </div>
           </v-textarea>
        </v-flex>
        <v-flex v-else>
            <v-textarea color="teal" id="inputGlobal" v-model="messageToManager" >
              <div slot="label">
                Notify Manager   
              </div>
            </v-textarea>
          <v-btn @click.prevent="sendMessageToManger">Send</v-btn>
        </v-flex >
    </v-form>
 </template>
 

<script>
  export default {
    data () {
      return{
        message: "",
        messageToManager: "",
        user: {},
      }
    },
    mounted(){
     //this.getUsers();
      this.user =  this.$store.state.user; 
      console.log(this.user);
    },
    methods: {  
          sendMessageToManger(){
            this.$socket.emit('msg_to_manager', this.messageToManager, 'send-notification',  this.$store.state.user);
          }
     },
      sockets:{ 
        msg_to_manager(dataFromServer){
          this.message = dataFromServer[0];

        }
      }
  }
</script>