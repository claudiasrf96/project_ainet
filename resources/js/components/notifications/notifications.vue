<template>
    <v-container grid-list-xl fluid>
      <v-layout wrap>
        <v-flex class="boxLeft">
              <v-slide-y-transition group style="background-color: none">
                  <div v-for="notification in notifications" v-bind:key = "notification.id">
                    <router-link :to="'/' + notification.path" >
                      <v-btn round color="blue"  @click="remove(notification.info)">  {{notification.info}}  &emsp; <v-icon dark>done</v-icon></v-btn>
                    </router-link>
                  </div>
            </v-slide-y-transition>
        </v-flex>
      </v-layout>
    </v-container>   
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
        index: 0
      }
    },
    mounted(){
    },
    methods: {  
          additem(id, path, notification){
            
            let newNotification = {};
            newNotification.id = id;
            newNotification.path = path;

            newNotification.info = notification;

            this.notifications.push(newNotification);
            console.log("a");
          },
          remove(btn){
            this.notifications.splice(btn.id , 1);
          }
        },
          sockets:{   
            connect(){
                console.log('socket connected (socket ID = '+this.$socket.id+')');
            },
           /* order_changed(dataFromServer){
                this.additem(dataFromServer[0].id, dataFromServer[1] );
            },
            msg_from_server(dataFromServer){
                this.additem(dataFromServer[0].id, dataFromServer[1] );
            },
            msg_from_server(dataFromServer){
                this.msgGlobalTextArea = dataFromServer + '\n' +
                this.msgGlobalTextArea ;
                this.additem(dataFromServer[0].id, dataFromServer[1] );

            }, 
            order_changed(dataFromServer){
                this.additem(dataFromServer[0].id, dataFromServer[1] );
            },
            order_deleted(dataFromServer){
                this.additem(dataFromServer[0].id, dataFromServer[1] );
            },
            meal_created(dataFromServer){
                this.additem(dataFromServer[0].id, dataFromServer[1] );
            },*/
            msg_to_manager(dataFromServer){
              this.additem(this.index, dataFromServer[1], dataFromServer[2]);
              this.index ++;
              console.log(dataFromServer);
            },
            order_arrived(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            order_changed_state_cook(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            order_delete(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            order_confirmed(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            order_created(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            invoice_created(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            invoice_closed(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,
            meal_manager(dataFromServer){
              this.additem(this.index, dataFromServer[1]);
              this.index ++;
              console.log(dataFromServer);
            }
            ,



      }
  }
</script>
<style>

.boxLeft{
  min-height: 700px;
}
.v-item-group {
  flex-direction: column;
}
</style>