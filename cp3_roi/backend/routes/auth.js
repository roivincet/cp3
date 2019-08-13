// Include the Express framework that we will depend on
const express = require('express');

// Load express router for separation of routes
const router = express.Router();

// Load JWT for JSON Web Token generation/signing
const jwt = require('jsonwebtoken');

// Load passport for authentication
const passport = require('passport');

// Load our customizations on the passport module
const appPassport = require('./../passport');

// Include our configuration within config.js
const config = require('./../config');

// Login User to the system
router.post('/login', (req, res, next) => {

  // Authenticate using the local passport library
	passport.authenticate('local', {session: false}, (err, user, info) => {

    // If we're unable to validate, request is unauthorized
    if (err || !user) {
        return res.status(400).json({
          'error': 'Something is not right',
         });
    }

    // Otherwise, log the user in and create a session
    req.login(user, {session: false}, (err) => {
      if (err) {
        res.send(err);
      }
      const token = jwt.sign(user.toJSON(), config.secretKey, { expiresIn: '30m' });
      return res.status(200).json({ 
          'data': { 
            'user': user,
            'token': token 
          }
      });
    });

  })(req, res);

});

//logout user
router.get('/logout', function(req, res){
  req.logout();
  return res.json({
    'message' : 'logged_out'
  });
});

module.exports = router;