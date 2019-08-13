@extends('layouts.app')

@section('title')
View Class


@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h2 id="productName"></h2>
        </div>
        <p id="description"></p>
        <p id="seats"></p>
        <p id="price"></p>

        <form id="buy">
            
            <div class="form-group">
                <label for="quantity">How many seats would you like to book?</label>
                <input type="number" name="quantity" id="quantity" min="1" max="${availability.seats}">
            </div>
            {{-- datepicker --}}
            <div class="form-group">
                <label for="quantity">What Date would you like to schedule?</label>
                 {{-- <input type="date" name="schedDate" id="date" /> --}}
            <input name="bookingDate" type='text' id="datepicker" />
            {{-- bookingdate yung req.body.bookingDate sa transactions.js --}}
            

                {{-- from roel --}}
                {{-- <script>
                    function pad(n) {
                            return n<10 ? '0'+n : n;
                        };

                            let currentDate = new Date()
                            let yyyy = currentDate.getFullYear();
                            let mm = currentDate.getMonth();
                            let dd = currentDate.getDate();

                            let mindate = yyyy + "-" + pad(mm+1) + "-" + pad(dd);

                            // let maxdate = yyyy + "-" + pad(mm+1) + "-" + pad(dd+2);

                        document.querySelector('#date').min=mindate;
                        // document.querySelector('#date').max=maxdate;


                </script> --}}
                {{-- end from roel --}}
                
                <script type='text/javascript'>
                $(document).ready(function(){

                 $('#datepicker').datepicker({
                  dateFormat: "yy-mm-dd",
                  maxDate:'+5d',
                  minDate: 0

                 });

                });
                </script>
            
            </div>
            {{-- datepicker --}}

            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="book()">Book now</button>
            </div>


        </form>
    </div>

    <script type="text/javascript">
        
        //send a GET request using the availability ID as a wildcard to view specific product details
        fetch('https://rfoundationmvnoel.herokuapp.com/availabilities/{{$id}}')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            document.getElementById("productName").innerHTML = data.availability.name;
            document.getElementById("description").innerHTML = data.availability.description;
            document.getElementById("seats").innerHTML = "Available seats: " + data.availability.seats;
            document.getElementById("bookedDate").innerHTML = "Available dates: " + data.availability.seats;
            document.getElementById("price").innerHTML = "Price per seat: " + data.availability.price;
            document.getElementById("date").innerHTML = "Date selected " + data.availability.date;
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
            let userId = localStorage.getItem('userId');
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
            let clientReq = new Request('https://rfoundationmvnoel.herokuapp.com/transactions/', initObject);

            //use above request object as the argument for our fetch request
            fetch(clientReq).then(function(response) {
                return response.json();
            })
            .then(function(response) {
                // console.log(response);
                window.location.replace('/transactions/'+userId) 
            })
            .catch(function(err) {
                console.log("Something went wrong!", err);
            });

       };
    </script>
@endsection