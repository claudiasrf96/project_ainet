<template>
    <v-container  justify-center  xs12>
        <v-flex xs7 align-center offset-xs2  justify-center>
            <form @submit.prevent="(validate() && submit())" lazy-validation>
                <v-text-field  v-model="user.password" 
                    data-vv-name="password_old"
                    data-vv-delay="200"
                    v-validate="'required|min:3|max:9'"
                    :error-messages="errors.collect('password_old')"
                    prepend-icon="lock"
                    label="Password"
                    :type="'password'" >
                </v-text-field> 
                <v-text-field  v-model="user.newPassword"  
                    ref="password"
                    name="password"
                    label="Nova Password" 
                    data-vv-name="password"
                    data-vv-delay="300"
                    v-validate="'required|min:3|max:9'"
                    :error-messages="errors.collect('password')"
                    prepend-icon="lock"
                    :type="'password'"
                     >
                    </v-text-field>
                <v-text-field v-model="newPasswordConf"  label="Confirmar a nova Password" 
                    
                    data-vv-name="password_confirmation"
                    data-vv-delay="300"
                    target= "password"
                    v-validate="'required|confirmed:password'"
                    :error-messages="errors.collect('password_confirmation')"
                    prepend-icon="lock"
                    :type="'password'"
                    >
                    
                </v-text-field>

                <v-btn @click="submit">submit</v-btn>
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
            newPasswordConf: '',
            dictionary: {
                custom: {
                    password: {
                        required: () => 'Password can not be empty',
                        max: 'The password field may not be greater than 9 characters',
                        min: 'The password field may not be lesser than 3 characters'
                    },
                    password_confirmation: {
                        required: () => 'Can not be empty',
                        confirmed: 'Does not match'
                    }
                }
            }
        }
    },
    mounted() {
        this.getUserInfor();
        this.$validator.localize('en', this.dictionary)    
    },
    methods: {
        changeUser(){
            axios.put('/api/users/updatePassword/' + this.user.id, this.user).then(response => {  
                this.$store.commit('setUser',response.data.data);
            })
            .catch(function(err) {
                console.log(err);
            });
        }, 
        getUserInfor() {
            this.user = this.$store.state.user;
            this.user.newPassword = "";
        },
        clear () {
            this.$validator.reset();
            this.user.password = ''
            this.user.newPassword = ''
            this.newPasswordConf = ''
        },
        submit () {
            this.$validator.validate().then(result => {
                if (!result) {
                    console.log('false')
                } else {
                    this.changeUser();
                }
            })
        },
    }
}
</script>