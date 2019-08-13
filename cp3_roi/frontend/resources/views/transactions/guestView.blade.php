@extends('layouts.app')

@section('title')
My Transactions
@endsection

@section('content')
    <table class="table table-striped table-responsive" id="tableNgMyTransactions">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Transaction ID</th>
                <th scope="col">Availability ID</th>
                <th scope="col">Seats Booked</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="transactions"></tbody>
    </table>

    <script type="text/javascript">
        fetch('https://rfoundationmvnoel.herokuapp.com/transactions/{{$id}}', {
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
                    <td>${transaction.date}</td>
                    <td>${transaction.bookedDate}</td>
                    <td>${transaction._id}</td>
                    <td>${transaction.availabilityId}</td>
                    <td>${transaction.quantity}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.status}</td>
                    <td><button class="btn btn-warning btn-block del-btn" id="${transaction._id}">Cancel booking</button>
                        <button class="btn btn-danger btn-block delete-btn" id="${transaction._id}" onclick="delete()">Delete</button>
                    </td>
                    
                </tr>
                `
                if(transaction.status == "cancelled") {
                    document.getElementById(transaction._id).disabled = true;
                } else {
                    document.getElementById(transaction._id).disabled = false;
                }
            });


            // delete booking
            document.querySelector('#transactions').addEventListener("click", 
                function(e) {
                    // console.log(e.target.className)
                    // if the delete button is clicked, log the element's data-id
                    if($(e.target).hasClass('deleteTrans') ) {
                        if(!confirm('Are you sure you want to delete this booking?')) {
                            return false
                        }
                        e.target.parentNode.parentNode.remove()
                        removeTransaction(e.target.dataset.id)
                    }
                })


            // delete backend

            function removeTransaction(id) {
                fetch('https://rfoundationmvnoel.herokuapp.com/transactions/delete', {
                    method : 'delete',
                    headers : {
                        'Content-Type' : 'application/json'
                    },
                    body :JSON.stringify({'id' : id})
                })
            }


            // cancel lang na sira
            //turn the del-btn class into an array
            let delButtons = document.querySelectorAll('.del-btn');

            //loop through the delButtons array to add an event listener and associate specific product id to each one
            delButtons.forEach(function(button) {
                //add onclick event listener to every button
                button.addEventListener('click', function() {
                    let id = this.getAttribute('id');
                    fetch(`https://rfoundationmvnoel.herokuapp.com/transactions/${id}`, {
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
                        return response.json();
                    })
                    .then(function(data) {
                        button.disabled = true;
                        window.alert(data.data.message);
                    })
                    .catch(function(err) {
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