/*
    Submit Login
    Vue and Axios
*/ 

'use strict';

var app = new Vue({

    el: '#myform',

    data:
    {
        message: null
    },

    methods: 
    {
        login: function(e)
        {
            var pass = document.getElementById("password");
            var user = document.getElementById("username");

            axios.post('api/login.php', 
            {
                username: user.value,
                password: pass.value
            })
            .then(function(response)
            {
                if(response.data.error == 1)
                {
                    app.message = response.data.message;
                }
                else if(response.data.error == 0)
                {
                    //window.location.replace(response.data.url);
                    app.message = response.data.message;
                }
            })
            .catch(function (error) 
            {
                console.log(error);
            });

            e.preventDefault();
        }
    }

})