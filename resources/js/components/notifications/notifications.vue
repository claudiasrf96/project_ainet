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
            <v-btn-toggle >
              <v-slide-y-transition group style="background-color: none">
                  <div v-for="notification in notifications" v-bind:key = "notification.id">
                    <v-chip  v-model="chip1"  close  @click="redirect()"> {{notification.info}} </v-chip>
                  </div>
            </v-slide-y-transition>
          </v-btn-toggle>
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
        notifications: [],
        
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
          redirect(){
            console.log("a");
          },
          additem(id, notification){
            
            let newNotification = {};
            newNotification.id = id;
            newNotification.info = notification;

            this.notifications.push(newNotification);
          }
     },
      sockets:{   
        connect(){
            console.log('socket connected (socket ID = '+this.$socket.id+')');
        },
        order_changed(dataFromServer){
            this.$toasted.show('Order ' + dataFromServer[0].id + ' has been ' + dataFromServer[1]);
            this.additem(dataFromServer[0].id, dataFromServer[1] );
        },
      }
  }
</script>
<style>

.boxLeft{
  min-height: 700px;
  border-left: 1px solid black
}
.v-item-group {
  flex-direction: column;
}
</style>