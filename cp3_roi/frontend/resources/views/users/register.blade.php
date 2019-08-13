@extends('layouts.app')

@section('title')
Register
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Register</div>
        <div id="status"></div>

        <div class="card-body">
            <form id="myForm">
         
        
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Name">
                </div>

                <div class="form-group">
                    <input type="text" name="userName" id="userName" placeholder="Username">
                </div>


                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" id="pw1" placeholder="Password">
                </div>

                <div class="form-group">
                    <input type="password" name="password2" id="pw2" placeholder="Verify password" onblur="pwCheck()">
                </div>


                <div class="form-group">
                    <button type="button" id="btn" class="btn-block mb-2" onclick="send()">Register now</button>
                </div>
{{-- onclick event listener to convert form data into json format then submit via fetch --}}
            </form>
        </div>
    </div>    

    <script>
        
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
        };
    </script>
@endsection