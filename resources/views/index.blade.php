<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Restaurante</title>
        @yield('extrastyles') 
        <!-- Latest compiled and minified CSS & JS -->
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

        </head> 
        <body>
        <div class="container" id="app">
        
            <router-link to="/users">Users</router-link>
            <router-link to="/logoutUsers">Logout</router-link>
            
            <router-view></router-view>
            <!-- <router-link to="/login"  v-show="!this.$store.state.user">Login</router-link>  -->
        </div>

    <script src="{{ asset('js/app.js') }}"></script>      
    </body>
</html>

