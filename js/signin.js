
'use strict';

var App = new Vue({

    el: '#myform',

    data: {

        errors: []
    },

    methods:
    {
        signin: function(e) {

            var email = document.getElementById("email");
            var user = document.getElementById("username");
            var password = document.getElementById("password");
            var confpass = document.getElementById("confpass");

            axios.post('api/create-user.php', {

                username: username.value,
                email: email.value,
                password: password.value,
                confpass: confpass.value

            })
            .then(response => this.errors = response.data)
            .catch(error => console.log(error))

            e.preventDefault();
        }
    }
})