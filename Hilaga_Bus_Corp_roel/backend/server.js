// Include the Express framework that we will depend on
const express = require('express');

// Include mongoose for handling multiple database connections
const mongoose = require('mongoose');

// Include JWT for handling JSON Web Tokens
const jwt = require('jsonwebtoken'); 

// Include our configuration within config.js
const config = require('./config');

// Add body parsing for JSON content types
const bodyParser = require('body-parser');

// Use passport for local authentication
const passport = require('passport');

// Imports cors to allow cross-origin request
const cors = require("cors");  

// use moment for timestamps
const moment = require("moment");

// Establish connection to the database
mongoose.connect('mongodb+srv://dbUser:123123123@cluster0-mfo2g.mongodb.net/booking?retryWrites=true&w=majority', { useNewUrlParser: true }); 

// Load the passport implemented strategies in another module
require('./passport');

// Instantiate the app
const app = express();

// Allow cross-origin request
app.use(cors());

// Configure middleware to use body parser for retrieving POST or URL parameters
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json())

// Configure application to use passport authentication
app.use(passport.initialize());	

// Load index.js for default routes
const index = require('./routes/index');
app.use('/', index);

// Load auth.js for auth related routes
const auth = require('./routes/auth');
app.use('/auth', auth);

//load availabilities.js for booking related routes
const availabilities = require('./routes/availabilities');
app.use('/availabilities', availabilities);

// Load user.js for user related routes
const user = require('./routes/users');
app.use('/users', passport.authenticate('jwt', {session: false}), user);

// Load transaction.js for transaction related routes
const transaction = require('./routes/transactions');
app.use('/transactions', transaction);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  var err = new Error('Not Found');
  err.status = 404;
  next(err);
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.json({ 'error': err.message });
});

// Start listening on the specified port
app.listen(config.port, () => {
  console.log('Server is running at: ', config.port);
});

module.exports = app;