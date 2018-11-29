<template>
    <div>
        <button @loginUser="loginUser">Login</button>
    </div>
</template>

<script>
    export default {
        methods: {
            loginUser: function(){
                this.$router.push('/login' );
            }
        }
    }
</script>