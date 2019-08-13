@extends('layouts.app')

@section('title')
Edit User Profile
@endsection

@section('content')


<table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
                
            </tr>
        </thead>

        <tbody id="availabilities">
            
        </tbody>
    </table>

{{-- EDIT USERS MODAL --}}
<div class="modal" id="editProfileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfile" enctype="multipart/form-data">
                    @csrf 
                    
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END EDIT PACKAGE MODAL --}}

<script>


        fetch('https://rfoundationmvnoel.herokuapp.com/users/all', {
            method: "GET",
            headers: {
                "Content-Type" : "application/json",
                "Authorization" : "Bearer " + localStorage.getItem('token')
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let profiles = data.data.user;
            users.forEach(function(user) {
                document.getElementById("users").innerHTML += `
                <tr>
                    <th scope="row">${profiles.name}</th>
                    <td>${profiles.userName}</td>
                    <td>${profiles.email}</td>
                    <button class="btn btn-danger" id="delAccount">Delete Account</button>
                </tr>
                ` 
            });
        })
        .catch(function(err) {
            console.log(err);
        });


let profileId = localStorage.getItem('userId')



// delete account
document.querySelector("#delAccount").addEventListener("click", function() {
            if(window.confirm("Are you sure you want to Delete this Account?")) {

                fetch('https://rfoundationmvnoel.herokuapp.com/'+ profileId, {
                method : 'delete',
                headers : {
                    'Content-Type' : 'application/json'
                },
                body : JSON.stringify({'id' : id})
                 } )

                // alert("hello")
                fetch('https://rfoundationmvnoel.herokuapp.com/auth/logout')
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