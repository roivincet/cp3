@extends('layouts.app')

@section('title')
Transactions History
@endsection

@section('content')
    <table class="table table-striped table-responsive" id="tableNgAllTransactions">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Transaction ID</th>
                <th scope="col">Email</th>
                <th scope="col">Availability ID</th>
                <th scope="col">Seats Booked</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody id="transactions"></tbody>
    </table>

    <script type="text/javascript">
        fetch('https://rfoundationmvnoel.herokuapp.com/transactions/all', {
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
                    <th scope="row">${transaction.date}</th>
                    <td>${transaction.bookedDate}</td>
                    <td>${transaction._id}</td>
                    <td>${transaction.ownerEmail}</td>
                    <td>${transaction.availabilityId}</td>
                    <td>${transaction.quantity}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.status}</td>
                </tr>
                ` 
            });
        })
        .catch(function(err) {
            console.log(err);
        });
    </script>

        
            

            
        
@endsection