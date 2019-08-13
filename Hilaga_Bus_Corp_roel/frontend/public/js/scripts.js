//toggle navbar to reflect different options depending on logged in user
function checkUser() {
			let isAdmin = localStorage.getItem('isAdmin');
			if(isAdmin == "true") {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/admin">HilaG<i class="fab fa-phoenix-framework"></i></a>
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">
					        <li class="nav-item">
						        <a class="nav-link" href="/admin"><i class="fas fa-map-marker-alt"></i><i class="fas fa-marker"></i>Create Trips</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/admin/transactions"><i class="fab fa-phoenix-framework"></i> Transactions</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/users/profile" id="profile"><i class="fas fa-user-alt"></i> Profile</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="#" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
					        </li>
					    </ul>
				    </div>
				`
			} else if(isAdmin == "false") {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/">HilaG<i class="fab fa-phoenix-framework"></i></a>

				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">
					        <li class="nav-item">
						        <a class="nav-link" href="/"><i class="fas fa-map-marker-alt"></i> Trips</a>
					        </li>
					        <li class="nav-item">
						        <a class="nav-link" href="/transactions/${localStorage.getItem('userId')}"><i class="fab fa-phoenix-framework"></i> My Transactions</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/users/profile" id="profile"><i class="fas fa-user-alt"></i> Profile</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="#" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
					        </li>
					            
					    </ul>
				    </div>
				`
			} else {
				document.getElementById("navBar").innerHTML = `
					<a class="navbar-brand" href="/">HilaG<i class="fab fa-phoenix-framework"></i></a>
				    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><span class="navbar-toggler-icon"></span>
				    </button>
				    <div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav ml-auto">
					        <li class="nav-item">
						        <a class="nav-link" href="/"><i class="fas fa-map-marker-alt"></i> Trips</a>
					        </li>
					        <li class="nav-item">
					            <a class="nav-link" href="/users/login"><i class="fas fa-sign-in-alt"></i> Login</a>
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

$(function () {
  $('[data-toggle="popover"]').popover()
})


