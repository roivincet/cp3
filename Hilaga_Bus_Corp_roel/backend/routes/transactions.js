// Include the Express framework that we will depend on
const express = require('express');

// Include the router used in express
const router = express.Router();

// Include the Transaction Model
const TransactionModel = require('./../models/Transaction');

// Include our configuration within config.js
const config = require('./../config');

// Import stripe for online payments
const stripe = require("stripe")(config.stripeSecretKey);

// use moment for timestamps
const moment = require("moment");

// include the Availability model
const AvailabilityModel = require('../models/Availability');

//include the User model
const UserModel = require('../models/User');

// Create a POST route for purchases
router.post('/', (req, res) => {
	// Search the specific availability to be booked
	AvailabilityModel.findOne({ "_id": req.body.id }).then( (availability) => {
		
		// Build the new transaction
		let newTransaction = new TransactionModel({
			'ownerEmail': req.body.email,
			'availabilityId': req.body.id,
			'quantity': req.body.quantity,
			'amount' : req.body.quantity * availability.price,
			'date' : moment().format('MM/DD/YYYY') 
		});

		// If no availability found, return an error
		if(!availability){
			return res.status(500).json({ 
				'error': 'No such availability found.',
			});
		}

		//throw an error if no seats available
		if(availability.seats == 0){
			return res.status(500).json({ 
				'error': 'Sorry, already full.',
			});
		}

		//otherwise, save transaction
		if(availability.seats > 0 && newTransaction.quantity <= availability.seats){
			//reduce the number of available seats by the quantity booked
			availability.seats = availability.seats - newTransaction.quantity;
			//deactivate availability once seats run out
			if(availability.seats == 0) {
				availability.isActive = false;
			}
			//save changes
			availability.save();	

		  	// Proceed to save the information to the data base
			newTransaction.save( (err, transaction) => {
				
				// If there is a problem with the database, throw an error
				if(err){
					return res.status(500).json({
						'error': err 
					});
				}

				// If database operation is successful return success
				return res.status(200).json(transaction);

			});

		} else {
			return res.json({
						'message': 'insufficient seats for intended booking'
					});
		}
	}).catch( err => {
				return res.json({ 
					'err': err,
				});
	});
});

// Create a POST route for Stripe purchases
router.post('/stripebuy', (req, res) => {

	AvailabilityModel.findOne({ "_id": req.body.availabilityId }).then( (availability) => {
		
		// Handle the Stripe purchase first
		stripe.customers.create({
			'email': req.body.buyerEmail,
			'source': req.body.stripeToken
		})
		.then( customer =>
		//assign user-provided values to keys provided by Stripe  
			stripe.charges.create({
				'amount': req.body.quantity * availability.price,
				'description': 'Booking made for ' + req.body.availabilityId,
				'currency': 'PHP',
				'customer': req.body.buyerEmail
			})
		);

		// Build the new transaction
		let newTransaction = new TransactionModel({
			'ownerEmail': req.body.buyerEmail,
			'availabilityId': req.body.availabilityId,
			'quantity': req.body.quantity,
			'amount' : req.body.quantity * availability.price
		});

		// If no availability found, return an error
		if(!availability){
			return res.status(500).json({ 
				'error': 'No such availability found.',
			});
		}

		//throw an error if no seats available
		if(availability.seats == 0){
			return res.status(500).json({ 
				'error': 'Sorry, already full.',
			});
		}

		//otherwise, save transaction
		if(availability.seats > 0 && newTransaction.quantity <= availability.seats){
			//reduce the number of available seats by the quantity booked
			availability.seats = availability.seats - newTransaction.quantity;
			//deactivate availability once seats run out
			if(availability.seats == 0) {
				availability.isActive = false;
			}
			//save changes
			availability.save();	

		  	// Proceed to save the information to the data base
			newTransaction.save( (err, transaction) => {
				
				// If there is a problem with the database, throw an error
				if(err){
					return res.status(500).json({
						'error': err 
					});
				}
				else {

					// If database operation is successful return success
					return res.status(200).json(transaction);
	
				}
			});

		} else {
			return res.json({
						'message': 'insufficient seats for intended booking'
					});
		}
	}).catch( err => {
				return res.json({ 
					'err': err,
				});
	});
});


// Retrieve all transactions 
router.get('/all', (req, res) => {
	// Find all transactions in the database for admin use
	TransactionModel.find({}).then( (transactions) => {

		// If no transactions are found, 
		if(!transactions){
			return res.status(200).json({ 
				'message': 'No transactions to show.'
			});
		}

		// Return all transactions of the user in session
		return res.status(200).json({ 
			'data': {
				'transactions': transactions
			}
		});
	});
});

// Retrieve all transactions of the logged in user
router.get('/:id', (req, res) => {
	//Find user email based on the user ID taken from URL
	
	UserModel.findOne({'_id': req.params.id}).then( (user) => {
		if(!user){
			return res.status(200).json({
				'message': 'No user found'
			});
		}

		let email = user.email;
		//find all transactions of specified user
		TransactionModel.find({'ownerEmail': email}).then( (transactions) => {
			// If no transactions are found, 
			if(!transactions){
				return res.status(200).json({ 
					'message': 'No transactions to show.'
				});
			}

			// Return all transactions of the user in session
			return res.status(200).json({ 
				'data': {
					'transactions': transactions
				}
			});
		});
	});
});

//create a new transaction to reflect cancellation
router.post('/:id', (req,res) => {
	TransactionModel.findOne({'_id' : req.params.id})
		.then(transaction => {
			if(transaction) {
				let oldTransaction = transaction;

				let newTransaction = new TransactionModel({
				'ownerEmail': oldTransaction.ownerEmail,
				'availabilityId': oldTransaction.availabilityId,
				'quantity': oldTransaction.quantity,
				'amount' : oldTransaction.amount,
				'status' : req.body.status,
				// 'date' : moment().format('MM/DD/YYYY')
				'date' : oldTransaction.date
				});

				console.log(transaction.status)

				// transaction.status = req.body.status
				// transaction.save()

				transaction.delete()

				newTransaction.save( (err, transaction) => {
				
					// If there is a problem with the database, throw an error
					if(err){
						return res.status(500).json({
							'error': err 
						});
					}

					// If database operation is successful return success
					return res.status(200).json({
						'data' : {
							'message' : 'cancelled successfully',
							'transaction' : transaction
						}
					});
				});
			}
			else {
			return res.json({
				'message' : 'No such transaction found'
				});
			}
		});
});

router.delete('/:id', (req, res, next) => {
	// console.log(req.body.devId)
	// res.send({type : 'DELETE'});
	console.log(req)
	TransactionModel.deleteOne({_id : req.body.id })
		.then(transaction => {
			res.send(transaction)
			console.log(res)
		}).catch(next)
})

module.exports = router;