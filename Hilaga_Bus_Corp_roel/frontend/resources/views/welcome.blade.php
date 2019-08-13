@extends('layouts.app')

@section('title')
Trips Available
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-1" id="landingPic">
                <img src="{{ asset('images/landingbus.png') }}" id="imageLanding">
            </div>

            <div class="col-md-4" id="bookSlogan">
               <a href="#welcomeView"><img src="{{ asset('images/booknow.png') }}" id="booknowTag"></a> 
                <h2 id="welcomeSlogan">Your comfortable way of travelling north!</h2>
            </div>

        </div>
        <div id="roadPic">
            
        </div>



    </div>


    <div class="container-fluid" id="welcomeView">
        <div class="row mt-4">
            <div class="col-md-10 offset-md-1 mt-3 p-0" id="tripsPanel">
                <table class="table table-striped table-hover">
                    <theader>
                        <th class="text-center">Bus</th>
                        <th class="text-center">From</th>
                        <th class="text-center">Destination</th>
                        <th class="text-center">Departure Date</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Available Seats</th>
                        <th class="text-center">Seat Price</th>
                        <th class="text-center">Action</th>
                    </theader>
                    <tbody id="products">
                    
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        fetch('http://localhost:3000/availabilities/').then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let availabilities = data.availabilities;
            availabilities.forEach(function(availability) {
                document.getElementById("products").innerHTML += 
                `
                <tr>
                    <td class="text-center">${availability.name}</td>
                    <td class="text-center">${availability.fromWhere}</td>
                    <td class="text-center">${availability.destination}</td>
                    <td class="text-center">${availability.isWhen}</td>
                    <td class="text-center">${availability.description}</td>
                    <td class="text-center">${availability.seats}</td>
                    <td class="text-center">${availability.price}</td>
                    <td class="text-center"><button class="btn btn-primary book-btn" id="${availability._id}">Book now!</button></td>
                </tr>
                `


                if(availability.isActive == false) {
                    document.getElementById(availability._id).disabled = true;
                    document.getElementById(availability._id).innerHTML = "Unavailable";
                } else {
                    document.getElementById(availability._id).disabled = false;
                }
            });

            //turn the book-btn class into an array
            let buttons = document.querySelectorAll('.book-btn');

            //loop through the buttons array to add an event listener and associate specific product id to each one
            buttons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id')
                    if(localStorage.getItem('token')==null) {
                        window.location.replace("/users/login");
                    } else { 
                        window.location.replace(`/availabilities/${id}`);
                    }
                });
            })
        })
        .catch(function(err) {
            console.log(err);
        });
    </script>

        
            

            
        
@endsection