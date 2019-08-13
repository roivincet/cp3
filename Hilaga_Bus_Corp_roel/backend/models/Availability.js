// Load Mongoose library for data modeling
const mongoose = require('mongoose');

// Load Mongoose schema for models
const Schema = mongoose.Schema;

// Create a new Schema for the Availability
const AvailabilitySchema = new Schema({ 
    name: String,
    description: String,
    fromWhere: String,
    destination: String,
    isWhen: String,
    seats: Number,
    price: Number,
    isActive: {type: Boolean, default: true}
});

// Set up the transaction model and export it to the main application
module.exports = mongoose.model('Availability', AvailabilitySchema);