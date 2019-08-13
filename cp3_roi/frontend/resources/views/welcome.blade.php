@extends('layouts.app')

@section('title')
MELN Home
@endsection

@section('content')

    
<div class="container" id="palitParallaxContainer">
    <div class="col md-12">
<ul id="vertical-column-hover">
  <li id="listItem">
    <span id="spanNgUL">Pasig</span>
    <img id="imgNgUL" src="http://mbpictures.ph/wp-content/uploads/2018/07/110718_WATERLILY_MANILA_01_DANCEL-600x400.jpg" /></li>
  
  <li id="listItem">
    <span id="spanNgUL">River</span>
    <img id="imgNgUL" src="http://newsinfo.inquirer.net/files/2014/04/ferry-0429.jpg" /></li>
  
  <li id="listItem">
    <span id="spanNgUL">Clean</span>
    <img id="imgNgUL" src="https://media.philstar.com/images/articles/met2-pasig-river-rehab-miguel-de-guzman_2018-08-12_20-14-12.jpg" /></li>
  
  <li id="listItem">
    <span id="spanNgUL">Up</span>
    <img id="imgNgUL" src="https://ak0.picdn.net/shutterstock/videos/2534510/thumb/1.jpg" />
  </li>
  
  <li id="listItem">
    <span id="spanNgUL">Drive</span>
    <img id="imgNgUL" src="http://1.bp.blogspot.com/_2TUvo3vtFf8/TCYLa8e9s6I/AAAAAAAAAJs/30UhF7ugcfs/s1600/pasig+river+and+rockwell.jpg" />
  </li>
</ul>
</div>
</div>


    <div class="container-fluid">
        <div class="row" id="products">



        
            


    <script type="text/javascript">
        fetch('https://rfoundationmvnoel.herokuapp.com/availabilities/').then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let availabilities = data.availabilities;
            availabilities.forEach(function(availability) {
                document.getElementById("products").innerHTML += `


                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" id="itemholder">
                        <div class="card shadow mt-2">
                            <div class="ribbon ribbon-top-right transparent">
                            <span>
                            <strong class="text-white">${availability.seats} Slots Left</strong>
                            </span>
                            <img class="card-img-top" src="https://www.filipinotravel.com.ph/wp-content/uploads/2015/10/sunset-cruise-Manila-Bay-_2.jpg" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">${availability.name}</h4>
                                <p class="card-text">${availability.description}</p>
                                <p class="card-text">Available seats: ${availability.seats}</p>
                                <p class="card-text">Rate per kilogram of waste collected: PhP ${availability.price}</p>
                                <button class="btn btn-primary book-btn" id="${availability._id}">Book now!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div> 
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

    $(document).ready(function(){
  // Activate Carousel
  $("#myCarousel").carousel();
    
  // Enable Carousel Indicators
  $(".item1").click(function(){
    $("#myCarousel").carousel(0);
  });
  $(".item2").click(function(){
    $("#myCarousel").carousel(1);
  });
  $(".item3").click(function(){
    $("#myCarousel").carousel(2);
  });
    
  // Enable Carousel Controls
  $(".carousel-control-prev").click(function(){
    $("#myCarousel").carousel("prev");
  });
  $(".carousel-control-next").click(function(){
    $("#myCarousel").carousel("next");
  });
});

    </script>

        
            

            
        
@endsection