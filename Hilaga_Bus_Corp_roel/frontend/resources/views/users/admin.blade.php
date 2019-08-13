@extends('layouts.app')

@section('title')
Admin Dashboard
@endsection

@section('content')
    <div class="container">
        
        <div class="col-md-8 offset-md-2 addAvailabilityPanel p-0">
            <div class="text-center mt-4 border p-2 bg-dark text-light">Add Trips</div>

        <div id="status"></div>
            
            <form id="addItem" class="p-3 border mb-2">         
            
                <div class="form-group row">
                    <label for="name" class="col-md-4">Name of availability:</label>
                    <input type="text" name="name" id="name" class="col-md-7" onkeyup="nameFunc()">
                    <span id="nameErr" class="offset-md-4"></span>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4">Brief Description:</label>
                    <input type="text" name="description" id="description" class="col-md-7" onkeyup="descFunc()">
                    <span id="descErr" class="offset-md-4"></span>
                </div>
                
                <div class="form-group row">
                    <label for="fromWhere" class="col-md-4">From:</label>
                    <input type="text" name="fromWhere" id="fromWhere" class="col-md-7" onkeyup="fromFunc()">
                    <span id="fromErr" class="offset-md-4"></span>
                </div>

                <div class="form-group row">
                    <label for="destination" class="col-md-4">Destination:</label>
                    <input type="text" name="destination" id="destination" class="col-md-7" onkeyup="destFunc()">
                    <span id="destErr" class="offset-md-4"></span>
                </div>

                <div class="form-group row">
                    <label for="isWhen" class="col-md-4">Date:</label>
                    <input type="date" name="isWhen" id="isWhen" class="col-md-7" onfocusout="dateFunc()">
                    <span id="dateErr" class="offset-md-4"></span>               
                </div>

                <div class="form-group row">
                    <label for="seats" class="col-md-4">Available Seats:</label>
                    <input type="number" name="seats" id="seats" class="col-md-7" onkeyup="seatFunc()" min="1" max="60">
                    <span id="seatsErr" class="offset-md-4"></span>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-4">Price per seat:</label>
                    <input type="number" name="price" id="price" class="col-md-7" onkeyup="priceFunc()" min="1">
                    <span id="priceErr" class="offset-md-4"></span>
                </div>

                <div class="form-group row mt-1 mb-1">
                    <a id="addToCat" href="#" onclick="submit()" class="col-md-3 btn btn-primary offset-md-4">Add to Trips</a>
                </div>

            </form>
        </div>

    </div>

    <hr>

    <div class="container" id="overviewAdmin">
            <h5 class="text-center bg-dark text-light p-3">Overview</h5>
            <table class="table table-striped table-responsive" id="adminAvailabilityPanel">
                <thead>
                    <tr>
                        {{-- <th scope="col" class="text-center">Availability ID</th> --}}
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Description</th>
                        <th scope="col" class="text-center">From</th>
                        <th scope="col" class="text-center">Destination</th>
                        <th scope="col" class="text-center">Date</th>
                        <th scope="col" class="text-center">Seats</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody id="availabilities">
                    
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        
        function nameFunc() {
            let name = document.querySelector("#name").value
            if(name == "") {
                document.querySelector("#nameErr").innerHTML = "* Name is a required Field"
                return false;
            } else {
                document.querySelector("#nameErr").innerHTML = "";
                return true;
            }
        }

        function descFunc() {
            let description = document.querySelector("#description").value
            if(description == "") {
                document.querySelector("#descErr").innerHTML = "* Description is a required Field"
                return false;
            } else {
                document.querySelector("#descErr").innerHTML = "";
                return true;
            }
        }

        function fromFunc() {
            let from = document.querySelector("#fromWhere").value
            if(from == "") {
                document.querySelector("#fromErr").innerHTML = "* From is a required Field"
                return false;
            } else {
                document.querySelector("#fromErr").innerHTML = "";
                return true;
            }
        }

        function destFunc() {
            let destination = document.querySelector("#destination").value
            if(destination == "") {
                document.querySelector("#destErr").innerHTML = "* Destination is required Field"
                return false;
            } else {
                document.querySelector("#destErr").innerHTML = "";
                return true;
            }
        }

        function dateFunc(){
            let pickedDate = document.querySelector('#isWhen').value
            let currentDate = new Date()
            pickedDate = new Date(pickedDate)
            pickedDate.setMinutes( pickedDate.getMinutes() + 959 );

            if(pickedDate<currentDate) {
                document.querySelector('#dateErr').innerHTML="* Invalid Date, It must be later than today";
                return false;
            } else if (pickedDate == "Invalid Date") {
                document.querySelector('#dateErr').innerHTML="* Date is a required field";
                return false;
            } else {
                document.querySelector('#dateErr').innerHTML="";
                return true;
            }
        }

        function pad(n) {
            return n<10 ? '0'+n : n;
        };

            let currentDate = new Date()
            let yyyy = currentDate.getFullYear();
            let mm = currentDate.getMonth();
            let dd = currentDate.getDate();

            let mindate = yyyy + "-" + pad(mm+1) + "-" + pad(dd+1);

        document.querySelector('#isWhen').min=mindate;

        // function date2Func() {
        //     document.querySelector("#isWhen").setAttribute('type', 'date')
        // }

        function seatFunc() {
            let seat = document.querySelector("#seats").value
            if(seat == "") {
                document.querySelector("#seatsErr").innerHTML = "* Seat is a required Field"
                return false;
            } else if(seat < 1 || seat > 60) {
                document.querySelector("#seatsErr").innerHTML = "* Seat must not be less than 1 or exceed 60"
                return false;
            } else {
                document.querySelector("#seatsErr").innerHTML = "";
                return true;
            }
        }

        function priceFunc() {
            let price = document.querySelector("#price").value
            if(price == "") {
                document.querySelector("#priceErr").innerHTML = "* Price is a required Field"
                return false;
            } else if(price < 1) {
                document.querySelector("#priceErr").innerHTML = "* Price must not be less than 1"
                return false;
            } else {
                document.querySelector("#priceErr").innerHTML = "";
                return true;
            }
        }

        function checkValidity() {
            valid = true;
            if(!priceFunc()){valid=false}
            if(!seatFunc()){valid=false}
            if(!dateFunc()){valid=false}
            if(!nameFunc()){valid=false}
            if(!descFunc()){valid=false}
            if(!destFunc()){valid=false}
            if(!fromFunc()){valid=false}
        }

        fetch('http://localhost:3000/availabilities/').then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let availabilities = data.availabilities;
            availabilities.forEach(function(availability) {
                document.getElementById("availabilities").innerHTML += `
                <tr>
                    <td>${availability.name}</td>
                    <td>${availability.description}</td>
                    <td>${availability.fromWhere}</td>
                    <td>${availability.destination}</td>
                    <td>${availability.isWhen}</td>
                    <td>${availability.seats}</td>
                    <td>${availability.price}</td>
                    <td>${availability.isActive}</td>
                    <td>
                        <button class="btn btn-block btn-info upd-btn" id="${availability._id}">Update</button>
                        <button class="btn btn-block btn-danger del-btn" id="${availability._id}">Disable</button>
                        <button class="btn btn-block btn-success act-btn" id="${availability._id}">Enable</button>
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
                    fetch(`http://localhost:3000/availabilities/${id}`, {
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
                        window.location.replace("/admin")
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
                    fetch(`http://localhost:3000/availabilities/${id}`, {
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
                        window.location.replace("/admin")
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
            // const formElement = document.getElementById('addItem');
            //using FormData, the form input names and their corresponding values will be transformed to JSON format
            checkValidity()
            if(valid == true) {

                let name = document.querySelector("#name").value
                let description = document.querySelector("#description").value
                let fromWhere = document.querySelector("#fromWhere").value
                let isWhen = document.querySelector("#isWhen").value
                let destination = document.querySelector("#destination").value
                let seats = document.querySelector("#seats").value
                let price = document.querySelector("#price").value

                const formData = new FormData();
                // iterate through the formData and save each key-value pair to JSON
                // let jsonObject = {};
                // for (const [key, value] of formData.entries()) {
                //     jsonObject[key] = value;
                // };
                // console.log(jsonObject);

                formData.name = name
                formData.description = description
                formData.fromWhere = fromWhere
                formData.isWhen = isWhen
                formData.destination = destination
                formData.seats = seats
                formData.price = price

                console.log(isWhen)
                console.log(formData)
                //store all headers into a single variable
                let reqHeader = new Headers();
                reqHeader.append('Access-Control-Request-Headers', 'Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization');
                reqHeader.append('Content-Type', 'application/json');
                reqHeader.append('Access-Control-Request-Method', 'POST');
                reqHeader.append('X-Requested-With', 'XMLHttpRequest');
                reqHeader.append('Authorization', 'Bearer ' + localStorage.getItem('token'));

                //create optional init object for supplying options to the fetch request
                let initObject = {
                    method: 'POST', headers: reqHeader, body: JSON.stringify(formData),
                };
                
                //create a resource request object through the Request() constructor
                let clientReq = new Request('http://localhost:3000/availabilities', initObject);

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
                } else {
                    document.querySelector('#addToCat').disabled
                }
            };
    </script>

        
            

            
        
@endsection