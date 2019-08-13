@extends('layouts.app')

@section('title')
My Transactions
@endsection

@section('content')

<div class="container" id="guestViewTrans">
    <div class="col-md-10 offset-md-1 p-0" id="myTransactionsPanel">
        <h5 class="text-center mt-4 border p-3 bg-dark text-light">My Transactions</h5>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th scope="col">Booked By:</th>
                    <th scope="col">Date:</th>
                    {{-- <th scope="col">Transaction ID</th> --}}
                {{-- <th scope="col">Availability ID</th> --}}
                    <th scope="col">Seats Booked:</th>
                    <th scope="col">Total Amount:</th>
                    <th scope="col">Status:</th>
                    <th scope="col">Action:</th>
                </tr>
            </thead>
            <tbody id="transactions"></tbody>
        </table>
    </div>
</div>

    <script type="text/javascript">
        fetch('http://localhost:3000/transactions/{{$id}}', {
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
            let transactions = data.data.transactions;

            transactions.forEach(function(transaction) {
                document.getElementById("transactions").innerHTML += `
                <tr>
                    <td>${transaction.ownerEmail}</td>
                    <td>${transaction.date}</td>
                    <td>${transaction.quantity}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.status}</td>
                    <td><button class="btn btn-danger del-btn" id="${transaction._id}">Cancel Booking</button></td>
                </tr>
                `

                if(transaction.status == "cancelled") {
                    document.getElementById(transaction._id).disabled = true;
                } else {
                    document.getElementById(transaction._id).disabled = false;
                }
            });
                    // <td>${transaction._id}</td>
                    // <td>${transaction.availabilityId}</td>

            //turn the del-btn class into an array
            let delButtons = document.querySelectorAll('.del-btn');

            //loop through the delButtons array to add an event listener and associate specific product id to each one
            delButtons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id');

                    let xxx = localStorage.getItem('userId');

                    fetch(`http://localhost:3000/transactions/${id}`, {
                        method: 'POST',
                        headers: {
                            "Access-Control-Request-Headers": "Content-Type, Access-Control-Request-Method, X-Requested-With, Authorization",
                            "Content-Type": "application/json",
                            "Access-Control-Request-Method": "POST",
                            "X-Requested-With": "XMLHttpRequest",
                            "Authorization": "Bearer " + localStorage.getItem('token')
                        },
                        body: JSON.stringify({
                            "status": "cancelled"
                        })
                    })
                    .then(function(response) {
                        console.log(response)
                        window.location.replace("/transactions/"+xxx)
                        return response.json();
                    })
                    .then(function(data) {
                        button.disabled = true;
                        window.alert(data.data.message);

                    })
                    .catch(function(err) {
                        console.log(id)
                        console.log("Something went wrong!", err);
                    });
                });
            });
        })
        .catch(function(err) {
            console.log(err);
        });
    </script>

        
            

            
        
@endsection