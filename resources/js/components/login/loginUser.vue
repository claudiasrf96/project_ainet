<template>

        <v-container>
            <v-layout align-center >
                <v-flex xs6 sm8 offset-sm2 >
                    <h2>Login</h2>

                    <v-text-field v-model="user.email" name="email" id="inputEmail" :counter="10" label="Name" data-vv-name="name" required></v-text-field>
                    <v-text-field :type="'password'" v-model="user.password" name="password" id="inputPassword" label="Password" data-vv-name="password"  required ></v-text-field>
                    
                    <v-btn @click.prevent="login">Login</v-btn>
                    <v-btn @click.prevent="cancel">Cancel</v-btn>
                    <v-alert  v-model="showMessage"  dismissible type="error" :color="alertType">
                        {{ message }}
                    </v-alert>
                </v-flex>
            </v-layout>
        </v-container>

</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                user: {
                    email:"",
                    password:""
                },
                typeofmsg: "alert-success",
                showMessage: false,
                message: "",
                alertType: "",
                alertIcon: "",
            }
        },
        methods: {
            login() {
                this.showMessage = false;
                axios.post('api/login', this.user)
                    .then(response => {
                        this.$store.commit('setToken',response.data.access_token);
                        return axios.get('api/users/me');
                    })
                    .then(response => {
                        this.$store.commit('setUser',response.data.data);
                        this.typeofmsg = "alert-success";
                        this.message = "User authenticated correctly";
                        this.showMessage = true;
                        this.alertType = "#4caf50";
                        this.$router.push({ name: 'profile' })
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Invalid credentials";
                        this.showMessage = true;
                        this.alertType = "#ff5252";
                    })
            },
            loginUser(e){
            }
        },
    }
</script>