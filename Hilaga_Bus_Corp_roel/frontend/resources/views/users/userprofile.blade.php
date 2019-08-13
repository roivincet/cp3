@extends('layouts.app')



@section('title')
Profile
@endsection


@section('content')
	
<div class="container">
    {{-- <h2 class="mb-4">User Profile:</h2> --}}
    <div class="row mt-4" id="profile">
        <div class="col-md-6 offset-3">
            <div class="card" id="cardProfilePanel">
                <div class="card-header bg-dark text-light">
                    <h2 class="text-center">My Profile</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                    <label class="col-md-4">Name:</label>
                    <p class="ml-5" id="profileName"></p>
                    </div>
                    <div class="row">
                    <label class="col-md-4">Username:</label>
                    <p class="ml-5" id="profileUsername"></p>
                    </div>
                    <div class="row">
                    <label class="col-md-4">Email:</label>
                    <p class="ml-5" id="profileEmail"></p>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger offset-3" id="delAccount">Delete Account</button>
                    <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                </div>
            </div>
        </div>   
    </div>
</div>

{{-- EDIT USERS MODAL --}}
<div class="modal fade" id="editProfileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title text-center">Edit Profile:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfile" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="nameProfile" class="offset-md-1 col-md-4">Edit Name:</label>
                        <input type="text" name="nameProfile" id="nameProfile" class="ml-2">
                    </div>
                    
                    <div class="form-group row">
                        <label for="usernameProfile" class="offset-md-1 col-md-4">Edit Username:</label>
                        <input type="text" name="usernameProfile" id="usernameProfile" class="ml-2">
                    </div>

                    <div class="form-group row">
                        <button class="btn btn-success col-md-4 offset-md-4 mt-2">Save Changes</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END EDIT PACKAGE MODAL --}}

<script>

let id = localStorage.getItem('userId')


fetch('http://localhost:3000/user/' + id)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            console.log(data)
            document.getElementById("profileName").innerHTML = data.data.user.name;
            document.getElementById("profileUsername").innerHTML = data.data.user.username;
            document.getElementById("profileEmail").innerHTML = data.data.user.email;

        })
       .catch(function(err) {
            console.log(err);
        });

document.querySelector("#delAccount").addEventListener("click", function() {
            if(window.confirm("Are you sure you want to delete your account? We will miss you :(")) {

                fetch('http://localhost:3000/'+ id, {
                method : 'delete',
                headers : {
                    'Content-Type' : 'application/json'
                },
                body : JSON.stringify({'id' : id})
                 } )

                // alert("hello")
                fetch('http://localhost:3000/auth/logout')
                .then((res) => {
                    return res.json();
                })
                .then((data) => {
                    // console.log(data)
                    localStorage.clear()
                    window.location.replace('/');
                })
                .catch(function(err) {
                    console.log(err)
                })
            }
            console.log(localStorage.user)
            console.log(localStorage.isAdmin)
            console.log(localStorage.token)
        })

</script>

@endsection