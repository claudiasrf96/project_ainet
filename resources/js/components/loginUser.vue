<template>
    <div>
        <div class="jumbotron">
            <h2>Login</h2>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="user.email" name="email" id="inputEmail" placeholder="Email address"/>
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" v-model="user.password" name="password" id="inputPassword"/>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="login">Login</a>
                <a class="btn btn-light" v-on:click.prevent="cancel">Cancel</a>
            </div>
            <v-alert  v-model="showMessage"  dismissible type="error" :color="alertType">
                {{ message }}
            </v-alert>
        </div>
    </div>
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
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Invalid credentials";
                        this.showMessage = true;
                        this.alertType = "#ff5252";
                        console.log(error);
                    })
            },
            cancel(){
                
            }
        },
    }
</script>