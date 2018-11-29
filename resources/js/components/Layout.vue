<template>
    <div>
        
       <!-- <router-link to="/users" class="btn btn-primary"  role="button">Users</router-link>-->
        <router-link to="/login-user"  class="btn btn-primary"  role="button">Login</router-link>
        <router-link to="/logout-user" class="btn btn-primary"  role="button">Logout</router-link>
        <!--<button @click="loginUser">Login</button>-->
    </div>
</template>

<script>
    export default {
        methods: {
            loginUser: function(){
                console.log("a");
                this.$router.push({ name: 'login' })
            }
        }
    }
</script>