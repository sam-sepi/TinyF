<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        .container
        {
            position: relative;
            top: 10vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="myform" @submit="login">
            <p v-if="message"> {{ message }} </p>
            <div class="row">
                <div class="input-field col s6">
                    <input id="username" type="text" class="validate" placeholder="Username">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="password" type="password" class="validate" placeholder="Password">
                </div>
            </div>
                <button class="btn black" type="submit" name="action">Login</button>
        </form>   
    </div>
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>