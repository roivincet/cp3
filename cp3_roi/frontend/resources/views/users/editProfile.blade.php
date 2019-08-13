@extends('layouts.app')

@section('title')
Edit User Profile
@endsection

@section('content')


<div class="main">
   <div class="container" id="editngcontainer">
    <div class="row" id="profile">
      <div class="text-container">
         <h2>User Profile:</h2>
         <label>Name</label>
                <p class="ml-5" id="profileName">
                    
                </p>
                <label>Username</label>
                <p class="ml-5" id="profileUsername">
                    
                </p>
                <label>Email</label>
                <p class="ml-5" id="profileEmail">
                    
                </p>

                <button class="btn btn-warning editPro" id="editProfile" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                <button class="btn btn-danger" id="delAccount">Delete Account</button>
         </p>
      </div>
    </div>
   </div>
</div>
  


{{-- EDIT USERS MODAL --}}
<div class="modal" id="editProfileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile:</h5>
                <button type="button btn-block mb-1" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" enctype="multipart/form-data">
                    @csrf 
                    
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END EDIT PACKAGE MODAL --}}

<script>

let profileId = localStorage.getItem('userId')


fetch('https://rfoundationmvnoel.herokuapp.com/user/' + profileId)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            //dynamically fill in product info from API's response
            console.log(data)
            document.getElementById("profileName").innerHTML = data.data.user.name;
            document.getElementById("profileUsername").innerHTML = data.data.user.userName;
            document.getElementById("profileEmail").innerHTML = data.data.user.email;

        })
       .catch(function(err) {
            console.log(err);
        });

// retrieve the specific user details for the modal
document.querySelector('#editProfile').addEventListener('click',
	function(e) {
		if($(e.target).hasClass('editPro')) {
			// console.log(e.target.dataset.id)

		let editId = localStorage.getItem('userId')
		console.log(editId)
		// EDIT USER
		fetch('https://rfoundationmvnoel.herokuapp.com/user/' + editId)
			.then(res => {
				return res.json()
			})
			.then(data => {
				const user = data.data.user
				console.log(data)
				let userDetails = '';

				userDetails += `
					{{ csrf_field() }}

					<label> Current Email: </label>
					<p>${user.email}</p>

					<label> Name: </label>
					<input data-id=${user._id} placeholder="${user.name}" id="editProName">
						<br>
					<label> Username: </label>
					<input data-id=${user._id} placeholder="${user.userName}" id="editProUserName">

					<input type="hidden" data-id=${user.id} value="${user._id}" id="editProId">
					<input type="hidden" data-id=${user.id} value="${user.isAdmin}" id="editProIsAdmin">
					<input type="hidden" id="editProEmail" type="email" data-id="${user._id}" class="form-control" name="email" value="${user.email}">	
					<input type="hidden" id="editProPassword" data-id="${user._id}" class="form-control" name="password" value="${user.password}">
						
                    <button id="editProfileSub" class="editSubmitButt btn btn-warning mt-3 data-dismiss="modal"> Edit My Profile Details </button>
				`
                document.querySelector('#editProfileForm').innerHTML = userDetails
			})
		}
	})

// select the edit form, when I click on it, a function will be called that will check if the b
document.querySelector('#editProfileForm').addEventListener('click', e => {
    if(e.target.id === 'editProfileSub') {
        console.log('you clicked the edit submit button')
        let id=document.querySelector('#editProId').value;
        let name=document.querySelector('#editProName').value;
        let userName=document.querySelector('#editProUserName').value;
        let email=document.querySelector('#editProEmail').value;
        let password=document.querySelector('#editProPassword').value;
        let isAdmin=document.querySelector('#editProIsAdmin').value;


        console.log(id)
        console.log(email)
        console.log(password)
        console.log(isAdmin)

        let formData = new FormData()
        formData._id = id
        formData.name = name
        formData.userName = userName
        formData.email = email
        formData.password = password
        formData.isAdmin = isAdmin

        console.log(formData)

        let editId = document.querySelector('#editProId').dataset.id
        console.log('this is the EDIT ID ' + editId)
        // console.log(e.target.parentNode,firstElementChild.nextElementSibling.dataset.id)

        fetch('https://rfoundationmvnoel.herokuapp.com/edit/' +editId , {
            method: 'PUT',
            headers: {
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(res => {
            window.location = '/users/editProfile'
        })
    }
})




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