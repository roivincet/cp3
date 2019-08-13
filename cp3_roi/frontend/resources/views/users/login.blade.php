@extends('layouts.app')

@section('title')
Log-in
@endsection

@section('content')
    <div class="card" id="loginCard">
        <div class="card-header">Log-in</div>

        <div class="card-body">
            <form id="myForm">
                 
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="pw1" placeholder="Password">
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block mb-2" onclick="login()">Login</button>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-info btn-block" onclick="register()">Register</button>
                </div>
{{-- onclick event listener to convert form data into json format then submit via fetch --}}
            </form>
        </div>
    </div>    

    <script>
        
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
            let clientReq = new Request('https://rfoundationmvnoel.herokuapp.com/auth/login', initObject);

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