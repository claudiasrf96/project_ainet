<template>
    <div>
        <div class="alert" :class="typeofmsg" v-if="showMessage">             
            <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
        </div>
        <div class="jumbotron">
            <h2>Confirmar Logout</h2>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="logout">Logout</a>
                <a class="btn btn-light" v-on:click.prevent="cancel">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                typeofmsg: "alert-success",
                showMessage: false,
                message: ""
            }
        },
        methods: {
            logout() {
                axios.post('api/logout')
                    .then(response => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;
                        this.$router.push({ name: 'root' })
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Logout incorrect. But local credentials were discarded";
                        this.showMessage = true;
                        console.log(error);
                    })           
                },
            cancel(){
                
            }
        }
    }
</script>