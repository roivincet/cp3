@extends('layouts.app')

@section('title')
Log-in
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6 mt-5 p-0 offset-md-3 loginPanel">
            <p class="navbar p-3 border bg-dark text-light">Log-in</p>
                <form id="myForm" class="p-3">       
                    <div class="form-group row">
                        <label for="email" class="text-md-left col-md-4">Email:</label>
                        <input type="email" name="email" id="email" class="col-md-7" onkeyup="emailFunc()">
                        <span id="emailErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="text-md-left col-md-4">Password:</label>
                        <input type="password" name="password" id="pw1" class="col-md-7" onkeyup="passFunc()" maxlength="12">
                        <span id="passErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <p class="col-md-8 offset-md-3">Don't have an account yet? Register <a onclick="register()" href="#">Now</a></p>
                    </div>

                    <div class="form-group row">
                        <button type="button" class="btn btn-primary col-md-3 offset-md-4" onclick="login()" id="loginBtn1">Login</button>
                    </div>
    {{-- onclick event listener to convert form data into json format then submit via fetch --}}
                </form>
        </div>
    </div>    

    <script>
        
        function emailFunc() {
            let email = document.querySelector('#email').value
            if(email == "") {
                document.querySelector('#emailErr').innerHTML = "* Email is Required"
            } else {
                document.querySelector('#emailErr').innerHTML = " "
            }
        }
        function passFunc() {
            let password = document.querySelector('#pw1').value
            if(password == "") {
                document.querySelector("#passErr").innerHTML = "* Password is Required"
            } else {
                document.querySelector("#passErr").innerHTML = " "
            }
        }
        
        function register() {
            window.location.replace("/users/register");
        }



        function login() {
            //select the form element
                const formElement = document.getElementById('myForm');
                //using FormData, the form input names and their corresponding values will be transformed to JSON format
                const formData = new FormData(formElement);
                //iterate through the formData and save each key-value pair to JSON
                let jsonObject = {};
                for (const [key, value] of formData.entries()) {
                    jsonObject[key] = value;
                };

                //store all headers into a single variable
                let reqHeader = new Headers();
                reqHeader.append('Access-Control-Request-Headers', 'Content-Type, Access-Control-Request-Method, X-Requested-With');
                reqHeader.append('Content-Type', 'application/json');
                reqHeader.append('Access-Control-Request-Method', 'POST');
                reqHeader.append('X-Requested-With', 'XMLHttpRequest');
                //create optional init object for supplying options to the fetch request
                let initObject = {
                    method: 'POST', headers: reqHeader, body: JSON.stringify(jsonObject),
                };

                //create a resource request object through the Request() constructor
                let clientReq = new Request('http://localhost:3000/auth/login', initObject);

                //pass the request object as an argument for our fetch request
                fetch(clientReq)
                    //return the response received from API as a JSON upon resolving this promise
                    .then(function(response) {
                        return response.json();
                    })
                    //pass the previously returned JSON response as an argument to the next promise
                    .then(function(response) {
                        //save received token from API into a variable
                        let userToken = (response.data.token);
                        //save user email from API response into a variable
                        let userEmail = (response.data.user.email);
                        //save user ID from API response into a variable
                        let userId = (response.data.user._id);
                        //save isAdmin status from API response into a variable
                        let userIsAdmin = (response.data.user.isAdmin);
                        //store token variable in localStorage for use in subsequent requests
                        localStorage.setItem('token', userToken);
                        //store user email variable in localStorage
                        localStorage.setItem('email', userEmail);
                        //store userIsAdmin variable in localStorage
                        localStorage.setItem('isAdmin', userIsAdmin);
                        //store userId variable in localStorage
                        localStorage.setItem('userId', userId);
                        //check if logged in user is an admin
                        if(response.data.user.isAdmin == true) {
                            //redirect to admin dashboard
                            window.location.replace("/admin");
                        } else {
                            //redirect back to catalogue
                            window.location.replace("/");
                        };                    
                    })

                    //catch any exception and display below message in the console
                    .catch(function(err) {
                        console.log("Something went wrong!", err);
                    });
        };
    </script>
@endsection