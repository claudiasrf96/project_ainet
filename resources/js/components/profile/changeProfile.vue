<template>
    <v-container  justify-center  xs12>
        <v-flex xs7 align-center offset-xs2  justify-center>
            <form>
                
                
                <input type="file" id="file" ref="file"  v-on:change="handleFileUpload()"/>
                <v-text-field v-model.lazy="user.name" :counter="20" label="Name" required ></v-text-field>
                <v-text-field v-model.lazy="user.username" :counter="20" label="Username" required></v-text-field>

                <v-btn @click="changeUser; submitFile()">submit</v-btn>
                <v-btn @click="clear">clear</v-btn>

            </form>
        </v-flex>
    </v-container>
</template>
<script>

export default {
    data () {
      return {
            user: [],
            file: ''
      }
    },
    mounted() {
       this.getUserInfor();    
    },
    methods: {
        clear () {
            this.name = ''
            this.username = ''
        },
        changeUser(){

            axios.put('/api/users/updateProfile/' + this.user.id, this.user).then(response => {  
                this.$store.commit('setUser',response.data.data);
            })
            .catch(function(err) {
                console.log(err);
            });
        }, 
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        submitFile(){
            let formData = new FormData();

            // Add the form data we need to submit
            formData.append('file', this.file);

            axios.post('/api/users/updateProfilePic/' + this.user.id, formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(response =>{
                this.$store.commit('setUser',response.data.data);
                //this.$emit('updatedPhoto', this.user);
                //console.log('SUCCESS!!');
            })
            .catch(function(){
            console.log('FAILURE!!');
            });
        },
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        }
    }
}
</script>
