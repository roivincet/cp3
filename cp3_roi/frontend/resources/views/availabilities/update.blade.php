@extends('layouts.app')

@section('title')
Update Availability
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Edit availability</div>
        <div id="status"></div>

        <div class="card-body">
            <form id="updItem">         
        
                <div class="form-group">
                    <label for="name">Edit name:</label>
                    <input type="text" name="name" id="name">
                </div>

                <div class="form-group">
                    <label for="description">Edit description:</label>
                    <input type="text" name="description" id="description">
                </div>

                <div class="form-group">
                    <label for="seats">Edit available seats</label>
                    <input type="number" name="seats" id="seats">
                </div>

                <div class="form-group">
                    <label for="price">Edit rate per kilogram of waste collected</label>
                    <input type="number" name="price" id="price">
                </div>

                <div class="form-group">
                    <a id="addToCat" href="#" onclick="submit()">Update availability</a>
                </div>

            </form>
        </div>
    </div>

    <script type="text/javascript">
        
        //send a GET request using the availability ID as a wildcard to view specific product details
        fetch('https://rfoundationmvnoel.herokuapp.com/availabilities/{{$id}}')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            //console.log(data.availability.name);
            document.getElementById("name").value = data.availability.name;
            document.getElementById("description").value = data.availability.description;
            document.getElementById("seats").value = data.availability.seats;
            document.getElementById("price").value = data.availability.price;
            document.getElementById("date").value = data.availability.date;
        })
       .catch(function(err) {
            console.log(err);
        });

       function submit() {
            //get quantity from form
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
            let clientReq = new Request('https://rfoundationmvnoel.herokuapp.com/availabilities/{{$id}}', initObject);

            //use above request object as the argument for our fetch request
            fetch(clientReq).then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log(data);
                document.getElementById("status").innerHTML = data.data.message;
            })
            .catch(function(err) {
                console.log("Something went wrong!", err);
            });

       };
    </script>
@endsection