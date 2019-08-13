// Load Mongoose library for data modeling
const mongoose = require('mongoose');

// Load Mongoose schema for models
const Schema = mongoose.Schema;

// Create a new Schema for the Transaction
const TransactionSchema = new Schema({ 
    ownerEmail: String, 
    availabilityId: String,
    quantity: Number,
    amount: Number,
    status: {type: String, default: "booked"},
    date: String
});

// Set up the transaction model and export it to the main application
module.exports = mongoose.model('Transaction', TransactionSchema);