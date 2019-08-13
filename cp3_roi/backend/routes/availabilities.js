// Include the Express framework that we will depend on
const express = require('express');

// Include the router used in express
const router = express.Router();

// Include the User Model
const AvailabilityModel = require('./../models/Availability');

// Retrieve all availabilities in the message board
router.get('/', (req, res) => {

	// Search for all the available bookings currently saved in the database
	AvailabilityModel.find({}, (err, availabilities) => {

		// If no bookings are available, return a successful request with info
		if(!availabilities){
			return res.status(200).json({ 
				'info': 'No bookings available at the moment.',
			});
		}

		// Return all availabilities found
		return res.status(200).json({
				'availabilities': availabilities,
		});
	});

});

// Add a new availability
router.post('/', (req, res) => {

	// Build the new availability
	let newAvailability = AvailabilityModel({
		'name': req.body.name,
		'description': req.body.description,
		'seats' : req.body.seats,
		'price': req.body.price,
		// 'bookedDate': req.body.date
	});

  	// Proceed to save the information to the data base
	newAvailability.save( (err, availability) => {

		// If there is a problem with the database, throw an error
		if(err){
			return res.status(500).json({
				'error': err
			});
		}
		// If database operation is successful return success
		return res.status(200).json({
			'data': {
				'message': 'availability added successfully',
				'availability': availability
			}
		});
	});
});

// Retrieve availabilities based on their id
router.get('/:id', (req, res) => {

	// Search for the specific availability based on the ID
	AvailabilityModel.findOne({ '_id': req.params.id }).then( (availability) => {

		// If no threads are available, return a successful request with info
		if(!availability){
			return res.status(200).json({ 
				'message': 'No available booking to show.'
			});
		}

		// Return the satisfying availability based on the ID
		return res.status(200).json({
				'availability': availability
		});

	});

});

// Retrieve availability for updating
router.put('/:id', (req, res) => {

	AvailabilityModel.update( { '_id' : req.params.id}, req.body )
		.then( availability => {
			if(availability) {
				return res.json({
					'data' : {
						'availability' : availability,
						'message' : 'Availability successfully updated.'
					}
				});
			}

			return res.json({
				'message' : 'No booking availability with the given ID found'
			});
		});
});

//delete an availability via its ID
router.delete('/:id', (req,res) => {
	AvailabilityModel.deleteOne({'_id' : req.params.id})
		.then(availability => {
			if(availability) {
				return res.json({
					'data' : {
						'availability' : availability
					}
				});
			}

			return res.json({
				'message' : 'No availability with the given ID found'
			});
		});
});

module.exports = router;