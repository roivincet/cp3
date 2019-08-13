@extends('layouts.app')

@section('title')
Transactions History
@endsection

@section('content')

<div class="container-fluid" id="transactionAdmin">
    <div class="col-md-10 offset-md-1 p-0" id="transactionAdminPanels">
        <h5 class="text-center mt-3 p-3 bg-dark text-light">Transactions Overview</h5>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                {{-- <th scope="col">Transaction ID</th> --}}
                <th scope="col">Email</th>
                <th scope="col">Date</th>
            {{--<th scope="col">Availability ID</th>--}}
                <th scope="col">Seats Booked</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="transactions"></tbody>
    </table>
    </div>
</div>

    <script type="text/javascript">
        fetch('http://localhost:3000/transactions/all', {
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
                    <th scope="row">${transaction.date}</th>
                    <td>${transaction.quantity}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.status}</td>
                    <td><button type="button" class="deleteButton" id="${transaction._id}">Delete</button></td>
                </tr>
                ` 
            })
            let deleteButton = document.querySelectorAll('.deleteButton');
                // console.log(deleteButton)
                deleteButton.forEach(function(button){

                    button.addEventListener('click', function(){
                    let id = this.getAttribute('id')
                    console.log(id)

                        if (window.confirm("Are you sure you want to delete transaction?")){
                            fetch('http://localhost:3000/transactions/${id}', {
                                'method' : "DELETE",
                                'headers' : {
                                    'Content-Type' : 'application/json'
                                },
                                body : JSON.stringify({'id' : id})
                            })
                        }
                        window.location.replace('/admin/transactions')
                    })
                })

        })
                

                    // <td>${transaction.availabilityId}</td>
                    // <td>${transaction._id}</td>

        // .catch(function(err) {
        //     console.log(err);
        // });


    </script>

        
            

            
        
@endsection