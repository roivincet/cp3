@extends('layouts.app')

@section('title')
Register
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6 mt-5 p-0 offset-md-3 registerPanel">
            <div class="navbar p-3 border bg-dark text-light">Register</div>
                
                <div id="status"></div>

                <form id="myForm" class="p-3">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-left">Name:</label>
                        <input type="text" name="name" id="name" class="col-md-7" onkeyup="nameFunc()">
                        <span id="nameErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-md-4 text-md-left">Username:</label>
                        <input type="text" name="username" id="username" class="col-md-7" onkeyup="usernameFunc()">
                        <span id="usernameErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 text-md-left">Password:</label>
                        <input type="password" name="password" id="pw1" class="col-md-7" onkeyup="pw1Func()">
                        <span id="pass1Err" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="password2" class="col-md-4 text-md-left">Verify Password:</label>
                        <input type="password" name="password2" id="pw2" onblur="pwCheck()" class="col-md-7" onkeyup="pw2Func()">
                        <span id="pass2Err" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 text-md-left">Email:</label>
                        <input type="email" name="email" id="email" class="col-md-7" onkeyup="emailFunc()">
                        <span id="emailErr" class="offset-md-4"></span>
                    </div>
                        
                    <div class="form-group row">
                        <p class="col-md-8 offset-md-3">Already have an Account? Login <a onclick="goToLogin()" href="#">Here</a></p>
                    </div>

                    <div class="form-group row">
                        <button type="button" id="btn" class="btn btn-danger col-md-3 offset-md-4" onclick="send()">Register now</button>
                    </div>
    {{-- onclick event listener to convert form data into json format then submit via fetch --}}
                </form>
            </div>
        </div>
    </div>    

    <script>
        
        function nameFunc() {
            let name = document.querySelector("#name").value

            if(name == ""){
                document.querySelector("#nameErr").innerHTML = "* Username is Required";
                return false;
            } else if (name.length > 16) {
                document.querySelector("#nameErr").innerHTML = "* Name must not exceed 8 characters";
                return false;
            } else {
                document.querySelector("#nameErr").innerHTML = "";
                return true;
            }

        }

        function usernameFunc() {
            let username = document.querySelector("#username").value

            if(username == ""){
                document.querySelector("#usernameErr").innerHTML = "* Username is Required";
                return false;
            } else if (name.length > 8) {
                document.querySelector("#usernameErr").innerHTML = "* Username must not exceed 8 characters";
                return false;
            } else {
                document.querySelector("#usernameErr").innerHTML = "";
                return true;
            }

        }

        function pw1Func() {
            let pass1 = document.querySelector("#pw1").value

            if(pass1 == ""){
                document.querySelector("#pass1Err").innerHTML = "* Password is Required"
                return false;
            } else if (pass1.length > 12) {
                document.querySelector("#pass1Err").innerHTML = "* Password must not exceed 12 characters";
                return false;
            } else {
                document.querySelector("#pass1Err").innerHTML = "";
                return true;
            }

        }

        function pw2Func() {
            let pass2 = document.querySelector("#pw2").value

            if(pass2 == ""){
                document.querySelector("#pass2Err").innerHTML = "* Password is Required"
                return false;
            } else if ( pass2.length > 12) {
                document.querySelector("#pass2Err").innerHTML = "* Password must not exceed 12 characters"
                return false;
            } else {
                document.querySelector("#pass2Err").innerHTML = "";
                return true;
            }

        }

        function emailFunc() {
            let email = document.querySelector("#email").value

            let validEmail = email.includes("@")

            if(email == ""){
                document.querySelector("#emailErr").innerHTML = "* Email is Required"
                return false;
            } else if (!validEmail){
                document.querySelector("#emailErr").innerHTML = "* Please Enter a valid email"
                return false;
            } else {
                document.querySelector("#emailErr").innerHTML = "";
                return true;
            }

        }

        function checkInput(){
            valid = true;
            if(!nameFunc()){valid=false}
            if(!pw1Func()){valid=false}
            if(!pw2Func()){valid=false}
            if(!emailFunc()){valid=false}
            if(!usernameFunc()){valid=false}
        }

        //to go to login page if guest already have an account
        function goToLogin() {
            window.location.replace("/users/login");
        }
        //disable button if passwords given don't match
        function pwCheck() {
            let pw1 = document.getElementById('pw1').value;
            let pw2 = document.getElementById('pw2').value;

            if(pw1!=pw2) {
                document.getElementById('btn').disabled = true;
                document.getElementById('status').innerHTML = "passwords don't match";
            } else {                
                document.getElementById('btn').disabled = false;
            }
        };

        function send() {
            //select the form element
            checkInput()

                if(valid == true) {
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
                let clientReq = new Request('http://localhost:3000/register', initObject);

                //pass the request object as an argument for our fetch request
                fetch(clientReq)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        console.log(JSON.stringify(data));
                        document.getElementById('status').innerHTML = JSON.stringify(data.message);
                    })
                    .catch(function(err) {
                        console.log("Something went wrong!", err);
                    });
                } else if(valid == false) {
                    document.querySelector("#btn").disabled
                }
        }
    </script>
@endsection