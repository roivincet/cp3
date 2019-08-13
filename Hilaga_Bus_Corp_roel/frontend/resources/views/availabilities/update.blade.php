@extends('layouts.app')

@section('title')
Update Availability
@endsection

@section('content')
    <div class="container" id="updateAdmin">
        <div class="col-md-8 offset-md-2 mt-3 p-0" id="editAvailabilityPanel">
            <div class="text-center mt-4 border p-2 bg-dark text-light">Edit Trip Details</div>
            <div id="status" class="text-center"></div>

                <form id="updItem" class="p-3 border mb-2">                    
                    {{-- <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-left">Edit Name:</label>
                        <input type="text" name="name" id="name" class="col-md-7" onkeyup="tripFunc()">
                        <span id="#nameErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 text-md-left">Edit Description:</label>
                        <input type="text" name="description" id="description" class="col-md-7" onkeyup="describeFunc()">
                        <span id="#descErr" class="offset-md-4"></span>
                    </div> --}}
                    <div class="form-group row">
                        <label for="trip" class="col-md-4 text-md-left">Edit From:</label>
                        <input type="text" name="trip" id="trip" class="col-md-7" onkeyup="tripFunc()">
                        <span id="tripErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="describe" class="col-md-4 text-md-left">Edit From:</label>
                        <input type="text" name="describe" id="describe" class="col-md-7" onkeyup="describeFunc()">
                        <span id="describeErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="fromWhere" class="col-md-4 text-md-left">Edit From:</label>
                        <input type="text" name="fromWhere" id="fromWhere" class="col-md-7" onkeyup="fromFunc()">
                        <span id="fromErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="destination" class="col-md-4 text-md-left">Edit Destination:</label>
                        <input type="text" name="destination" id="destination" class="col-md-7" onkeyup="destFunc()">
                        <span id="destErr" class="offset-md-4"></span>
                    </div>
                    
                    <div class="form-group row">
                        <label for="isWhen" class="col-md-4 text-md-left">Edit Date:</label>
                        <input type="date" name="isWhen" id="isWhen" class="col-md-7" onfocusout="dateFunc()">
                        <span id="dateErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="seats" class="col-md-4 text-md-left">Edit Available Seats</label>
                        <input type="number" name="seats" id="seats" class="col-md-7" onkeyup="seatFunc()">
                        <span id="seatsErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-md-4 text-md-left">Edit Price per Seat</label>
                        <input type="number" name="price" id="price" class="col-md-7" onkeyup="priceFunc()">
                        <span id="priceErr" class="offset-md-4"></span>
                    </div>

                    <div class="form-group row">
                        <a href="/admin" class="btn btn-danger offset-md-4 text-md-right">Cancel</a>
                        <a id="addToCat" href="#" onclick="submit()" class="btn btn-dark ml-1">Update</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function tripFunc() {
            let trip = document.querySelector("#trip").value
            if(trip == "") {
                document.querySelector("#tripErr").innerHTML = "* Name is a required Field"
                return false;
            } else {
                document.querySelector("#tripErr").innerHTML = "";
                return true;
            }
        }

        function describeFunc() {
            let description = document.querySelector("#describe").value
            if(description == "") {
                document.querySelector("#describeErr").innerHTML = "* Description is a required Field"
                return false;
            } else {
                document.querySelector("#describeErr").innerHTML = "";
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
            if(!tripFunc()){ valid = false}
            if(!describeFunc()){ valid = false}
            if(!destFunc()){ valid = false}
            if(!seatFunc()){ valid = false}
            if(!dateFunc()){ valid = false}
            if(!priceFunc()){ valid = false}
            if(!fromFunc()){ valid = false}
        }
        

        //send a GET request using the availability ID as a wildcard to view specific product details
        fetch('http://localhost:3000/availabilities/{{$id}}')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            //console.log(data.availability.name);
            document.getElementById("trip").value = data.availability.name;
            document.getElementById("describe").value = data.availability.description;
            document.getElementById("fromWhere").value = data.availability.fromWhere;
            document.getElementById("destination").value = data.availability.destination;
            document.getElementById("seats").value = data.availability.seats;
            document.getElementById("price").value = data.availability.price;
            document.getElementById("isWhen").value = data.availability.isWhen;
        })
       .catch(function(err) {
            console.log(err);
        });

       function submit() {

            checkValidity()
            //get quantity from form
            if (valid == true) {
                const formElement = document.getElementById('updItem');
                const formData = new FormData(formElement);
                let jsonObject = {};
                for (const [key, value] of formData.entries()) {
                    jsonObject[key] = value;
                };
                //add ID of chosen booking to jsonObject
                jsonObject.id = "{{$id}}";
                //add user email to jsonObject
                //jsonObject.email = localStorage.getItem('email');
                console.log(JSON.stringify(jsonObject));

                //store all headers into a single variable
                let reqHeader = new Headers();
                reqHeader.append('Access-Control-Request-Headers', 'Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization');
                reqHeader.append('Content-Type', 'application/json');
                reqHeader.append('Access-Control-Request-Method', 'PUT');
                reqHeader.append('X-Requested-With', 'XMLHttpRequest');
                reqHeader.append('Authorization', 'Bearer ' + localStorage.getItem('token'));

                //create optional init object for supplying options to the fetch request
                let initObject = {
                    method: 'PUT', headers: reqHeader, body: JSON.stringify(jsonObject),
                };

            //create a resource request object through the Request() constructor
                let clientReq = new Request('http://localhost:3000/availabilities/{{$id}}', initObject);

                //use above request object as the argument for our fetch request
                fetch(clientReq).then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    console.log(data);
                    document.getElementById("status").innerHTML = data.data.message;
                    window.location.replace("/admin")
                })
                .catch(function(err) {
                    console.log("Something went wrong!", err);
                });

                } else {
                    document.querySelector("#addToCat").disabled
                }
        };
    </script>
@endsection