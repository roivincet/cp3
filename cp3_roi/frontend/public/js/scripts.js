//toggle navbar to reflect different options depending on logged in user
function checkUser() {
			let isAdmin = localStorage.getItem('isAdmin');
			if(isAdmin == "true") {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/admin">r/Foundation Admin</a>
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				    <span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">

					        <li class="nav-item">
						        <a class="nav-link" href="/admin">Availabilities</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/admin/transactions">All Transactions</a>
					        </li>

					        <li class="nav-item dropdown id="navDropdown">
					        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Manage Account
        </a> 
							
	<!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
          <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/users/editProfile">Edit Own Profile</a>
            <a class="dropdown-item" href="/users/deleteUserProfiles">Delete User Profiles</a>
            <a class="dropdown-item" href="#" id="logout">Logout</a>
            
          </div>			
					        </li>    

					    </ul>
				    </div>
				`
			} else if(isAdmin == "false") {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/">r/Foundation</a>
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				    <span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">
					        
					        <li class="nav-item">
						        <a class="nav-link" href="/">Catalogue</a>
					        </li>

							<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Manage Account
        </a> 
							
	<!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
          <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/users/editProfile">Edit Profile</a>
            <a class="dropdown-item" href="/transactions/${localStorage.getItem('userId')}">My Transactions</a>
            <a class="dropdown-item" href="#" id="logout">Logout</a>
            
          </div>	
					        
					        </li> 

					    </ul>
				    </div>
				`
			} else {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/">r/Foundation Guest View</a>
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				    <span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">

					        <li class="nav-item">
						        <a class="nav-link" href="/">Catalogue</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/users/login">Login</a>
					        </li>    
					    </ul>
				    </div>
				`
			}
		};

checkUser();

function logout() {

	fetch('http://localhost:3000/auth/logout', {
            method: "GET",
            headers: {
                "Authorization" : "Bearer " + localStorage.getItem('token')
            }
        })
		.then(function(response) {
            return response.json();
        })
        .then(function(data) {
            localStorage.clear();
            window.location.replace("/");
        })
        .catch(function(err) {
            console.log(err);
        });
};

//if logout button exists, assign an onclick event for logging out
let logoutButton = document.getElementById("logout");
if(logoutButton) {
	logoutButton.addEventListener("click", logout);
}



// for edit user modal
let id = localStorage.getItem('id')


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
// for edit user modal       