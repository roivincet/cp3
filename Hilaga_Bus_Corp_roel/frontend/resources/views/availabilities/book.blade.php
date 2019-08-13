@extends('layouts.app')

@section('title')
View Class


@endsection

@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3 mt-5 p-0" id="bookNowPanels">
            <div class="border p-2 bg-dark text-light">
                <h4 id="productName" class="text-center"></h4>
            </div>
            <div class="p-3 border mb-2">
                <div class="row">
                <p class="col-md-4">Description:</p>  
                <p id="description" class="col-md-6"></p>
                </div>

                <div class="row">
                <p class="col-md-4">Seats Available:</p>  
                <p id="seats" class="col-md-6"></p>
                </div>

                <div class="row">
                <p class="col-md-4">Seat Price:</p>  
                <p id="price" class="col-md-6"></p>          
                </div>


                <form id="buy">
                    
                    <div class="form-group row">
                        <label for="quantity" class="col-md-8">How many seats would you like to book?</label>
                        <input type="number" name="quantity" id="quantity" min=1 class="col-md-2" max="20" onkeyup="checkQuantity()" oninput="validity.valid||(value='');">
                        <span id="ticketQuantityErr" class="offset-md-8"></span>
                    </div>

                    <div class="form-group row">
                        <button type="button" class="btn btn-danger offset-md-4" onclick="cancel()">Cancel</button>
                        <button type="button" class="btn btn-primary ml-1" onclick="book()" id="bookButton">Book now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function cancel() {
            window.location.replace('/')
        }
        
        function checkQuantity() {
            let quantity = document.querySelector("#quantity").value

            if (quantity.length == 0) {
                document.querySelector("#ticketQuantityErr").innerHTML = "Input is Required"
                return false;
            } else if (quantity.length > 2 || quantity>20) {
                document.querySelector("#ticketQuantityErr").innerHTML = "You can not book more than 20 seats in total"
                return false;
            } else if (quantity < 1){
                document.querySelector("#ticketQuantityErr").innerHTML = "Valid number is Required"
                return false;
            }
            else {
                document.querySelector("#ticketQuantityErr").innerHTML = "";
                return true;
            }
        }       
        //send a GET request using the availability ID as a wildcard to view specific product details
        fetch('http://localhost:3000/availabilities/{{$id}}')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            document.getElementById("productName").innerHTML = data.availability.name;
            document.getElementById("description").innerHTML = data.availability.description;
            document.getElementById("seats").innerHTML = data.availability.seats;
            document.getElementById("price").innerHTML = data.availability.price;
        })
       .catch(function(err) {
            console.log(err);
        });

       function book() {
                //get quantity from form
                const formElement = document.getElementById('buy');
                const formData = new FormData(formElement);
                let jsonObject = {};
                for (const [key, value] of formData.entries()) {
                    jsonObject[key] = value;
                };
                //add ID of chosen booking to jsonObject
                jsonObject.id = "{{$id}}";
                //add user email to jsonObject
                jsonObject.email = localStorage.getItem('email');
                jsonObject.userID = localStorage.getItem('userId');
                console.log(JSON.stringify(jsonObject));

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
                let clientReq = new Request('http://localhost:3000/transactions/', initObject);

                //use above request object as the argument for our fetch request
                fetch(clientReq).then(function(response) {
                    return response.json();
                })
                .then(function(response) {
                    console.log(response);
                    window.location.replace("/transactions/"+jsonObject.userID)

                })
                .catch(function(err) {
                    console.log("Something went wrong!", err);
                });
       };
    </script>
@endsection