@extends('layouts.app')

@section('title')
Admin Dashboard
@endsection

@section('content')
    <div class="card" id="cardNgAdmin">
        <div class="card-header">Add availability</div>
        <div id="status"></div>

        <div class="card-body">
            <form id="addItem">         
        
                <div class="form-group">
                    <label for="name">Name of availability:</label>
                    <input type="text" name="name" id="name">
                </div>

                <div class="form-group">
                    <label for="description">Describe the availability briefly:</label>
                    <input type="text" name="description" id="description">
                </div>

                <div class="form-group">
                    <label for="seats">How many seats are available?</label>
                    <input type="number" name="seats" id="seats">
                </div>

                <div class="form-group">
                    <label for="price">Rate per kilogram of waste collected:</label>
                    <input type="number" name="price" id="price">
                </div>

                <div class="form-group">
                    <label for="date">Date Availability:</label>
                    <input type='text' id="datepicker" name="date" />
                    <script type='text/javascript'>
                $(document).ready(function(){

                 $('#datepicker').datepicker({
                  dateFormat: "yy-mm-dd",
                  maxDate:'+90d',
                  minDate: 0

                 });

                });
                </script>
                </div>

                <div class="form-group">
                    <a id="addToCat" class="btn-block text-center" href="#" onclick="submit()">Add to catalogue</a>
                </div>

            </form>
        </div>
    </div>

    <hr>

    <table class="table table-striped table-responsive" id="tableUnderCreate">
        <thead>
            <tr>
                <th scope="col">Availability ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Seats</th>
                <th scope="col">Price</th>
                <th scope="col">isActive?</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

        <tbody id="availabilities">
            
        </tbody>
    </table>

    <script type="text/javascript">

        fetch('https://rfoundationmvnoel.herokuapp.com/availabilities/').then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let availabilities = data.availabilities;
            availabilities.forEach(function(availability) {
                document.getElementById("availabilities").innerHTML += `
                <tr>
                    <td>${availability._id}</td>
                    <td>${availability.name}</td>
                    <td>${availability.description}</td>
                    <td>${availability.seats}</td>
                    <td>${availability.price}</td>

                    <td>${availability.isActive}</td>
                    <td>
                        <button class="btn btn-info upd-btn" id="${availability._id}">Update</button>
                        <button class="btn btn-danger del-btn" id="${availability._id}">Disable</button>
                        <button class="btn btn-success act-btn" id="${availability._id}">Enable</button>
                    </td>
                </tr>
                `
            });

            //turn the upd-btn class into an array
            let updButtons = document.querySelectorAll('.upd-btn');

            //turn the del-btn class into an array
            let delButtons = document.querySelectorAll('.del-btn');

            //turn the act-btn class into an array
            let actButtons = document.querySelectorAll('.act-btn');

            //loop through the updButtons array to add an event listener and associate specific product id to each one
            updButtons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id')
                    window.location.replace(`/availabilities/update/${id}`);
                });
            })
            //loop through the delButtons array to add an event listener and associate specific product id to each one
            delButtons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id')
                    fetch(`https://rfoundationmvnoel.herokuapp.com/availabilities/${id}`, {
                        method: 'PUT', 
                        headers: {
                            "Access-Control-Request-Headers": "Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization",
                            "Content-Type": "application/json",
                            "Access-Control-Request-Method": "PUT",
                            "X-Requested-With": "XMLHttpRequest",
                            "Authorization": "Bearer " + localStorage.getItem('token')
                        },
                        //instead of deleting availabilities, disable them
                        body: JSON.stringify({
                            "isActive": false
                        }),
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        window.alert(data.data.message);
                    })
                    .catch(function(err) {
                        console.log("Something went wrong!", err);
                    });
                });
            });
            //loop through the actButtons array to add an event listener and associate specific product id to each one
            actButtons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id')
                    fetch(`https://rfoundationmvnoel.herokuapp.com/availabilities/${id}`, {
                        method: 'PUT', 
                        headers: {
                            "Access-Control-Request-Headers": "Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization",
                            "Content-Type": "application/json",
                            "Access-Control-Request-Method": "PUT",
                            "X-Requested-With": "XMLHttpRequest",
                            "Authorization": "Bearer " + localStorage.getItem('token')
                        },
                        //instead of deleting availabilities, disable them
                        body: JSON.stringify({
                            "isActive": true
                        }),
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        window.alert(data.data.message);
                    })
                    .catch(function(err) {
                        console.log("Something went wrong!", err);
                    });
                });
            });
        })
        .catch(function(err) {
            console.log(err);
        });

        function submit() {
            //select the form element
            const formElement = document.getElementById('addItem');
            //using FormData, the form input names and their corresponding values will be transformed to JSON format
            const formData = new FormData(formElement);
            //iterate through the formData and save each key-value pair to JSON
            let jsonObject = {};
            for (const [key, value] of formData.entries()) {
                jsonObject[key] = value;
            };
            console.log(jsonObject);

            //store all headers into a single variable
            let reqHeader = new Headers();
            reqHeader.append('Access-Control-Request-Headers', 'Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization');
            reqHeader.append('Content-Type', 'application/json');
            reqHeader.append('Access-Control-Request-Method', 'POST');
            reqHeader.append('X-Requested-With', 'XMLHttpRequest');
            reqHeader.append('Authorization', 'Bearer ' + localStorage.getItem('token'));

            //create optional init object for supplying options to the fetch request
            let initObject = {
                method: 'POST', headers: reqHeader, body: JSON.stringify(jsonObject),
            };
            
            //create a resource request object through the Request() constructor
            let clientReq = new Request('https://rfoundationmvnoel.herokuapp.com/availabilities', initObject);

            //pass the request object as an argument for our fetch request
            fetch(clientReq)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    console.log(JSON.stringify(data));
                    document.getElementById('status').innerHTML = JSON.stringify(data.data.message);
                })
                .catch(function(err) {
                    console.log("Something went wrong!", err);
                });
        };
    </script>

        
            

            
        
@endsection