<template>
    <div>
       
        <v-container  justify-center  xs12>
            <v-flex xs7 align-center offset-xs2  justify-center>
                 <v-avatar size="150" color="grey lighten-4"
                    >
                        <img :src="'storage/profiles/' + user.photo_url" >
                    </v-avatar>
                    <br>
                    <br>
                    <br>
                    <br>
                <form>
                    <v-flex class="upload-btn-wrapper"  >
                        <button class="btn">Atualizar Imagem</button>
                    <input type="file" id="file" ref="file" name="myfile"  v-on:change="handleFileUpload()"/>
                    
                    </v-flex>
                    <v-text-field v-model="user.email" label="Email" disabled  required ></v-text-field>
                    <v-text-field v-model.lazy="user.name" label="Name" required 
                        ref="name"
                        name="name"
                        data-vv-name="name"
                        data-vv-delay="300"
                        v-validate="'required|min:3'"
                        :error-messages="errors.collect('name')"
                    ></v-text-field>
                    <v-text-field v-model.lazy="user.username" label="Username" required
                        ref="username"
                        name="username"
                        data-vv-name="username"
                        data-vv-delay="300"
                        v-validate="'required|min:3'"
                        :error-messages="errors.collect('username')"
                    ></v-text-field>

                    <v-btn @click=" submitType()">submit</v-btn>
                    <v-btn @click="clear">clear</v-btn>

                </form>
            </v-flex>
        </v-container>
    </div>
</template>
<script>

export default {
    data () {
      return {
            user: [],
             dictionary: {
                custom: {
                    name: {
                        required: () => 'Can not be empty',
                        min: 'The name fiel may not be lesser than 3 characters'
                    },
                    username: {
                        required: () => 'Can not be empty',
                        min: 'The name fiel may not be lesser than 2 characters'
                    }
                }
            }
      }
    },
    mounted() {
       this.getUserInfor();    
    },
    methods: {
        clear () {
            this.user.name = '',
            this.user.username = '',
            this.file = ''
        },
        changeUser(){
            this.$validator.validate().then(result => {
                if (!result) {
                    console.log('false')
                } else {
                    axios.put('/api/users/updateProfile/' + this.user.id, this.user).then(response => {  
                    this.$store.commit('setUser',response.data.data);
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
                }
            })
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        submitType(){
            if( this.file != ''){
                this.submitFile();
            }
            this.changeUser();
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
                this.$emit('updatedPhoto', response.data.data.photo_url);
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

