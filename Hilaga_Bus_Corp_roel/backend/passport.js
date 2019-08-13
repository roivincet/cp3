// Use passport for local authentication
const passport = require('passport');

// Use passportJWT for authenticated web tokens
const passportJWT = require('passport-jwt');

// Load JWT extraction for extracting web tokens later on
const ExtractJWT = passportJWT.ExtractJwt;

// Use a local strategy for authenticating users
const LocalStrategy = require('passport-local').Strategy;

// Use JWT strategy for web tokens
const JWTStrategy = passportJWT.Strategy;

// Include the User Model
const UserModel = require('./models/User');

// Include bcrypt library for encryption
const bcrypt = require('bcrypt-nodejs');

// Import moment for date parsing and handling
const moment = require('moment');

// Serialize the user for session handling
passport.serializeUser((user, done) => {
	if(!user._id){
		user._id = user.sub;
	}
  	done(null, user._id);
});

// Declare how the user is deserialized
passport.deserializeUser((id, done) => {
  done(null, user._id);
});

// configure passport.js to use the local strategy
passport.use(new LocalStrategy({ usernameField: 'email' }, (email, password, done) => {

    // Query for a user that matches the email provided
	UserModel.findOne({ 'email': email }).then( (user) => {

		// Uncomment this to view the user that is being checked for authentication
		//console.log(user);

		if(!user){
			// Invalidate users
			return done(null, false, { message: 'Invalid credentials.\n' });
		}

		if(email==user.email){

			// Check for password hash compared to the stored password
			if (!bcrypt.compareSync(password, user.password)) {
				// Return invalid credentials if log in is invalied
	        	return done(null, false, { message: 'Invalid credentials.\n' });
	      	}

	      	// Return successful login if a match is found
	      	return done(null, user);

		}

		// Invalidate users
		return done(null, false, { message: 'Invalid credentials.\n' });

	});

}));

// Configure passport for JWT usage in verification
passport.use(new JWTStrategy({
        jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
        secretOrKey   : 'MELN Project'
    },
    function (jwtPayload, cb) {
        // Fine the user in the database as needed
        return UserModel.findOne( jwtPayload.id )
            .then(user => {
                return cb(null, user);
            })
            .catch(err => {
                return cb(err);
            });
    }
));

// Retrieve account information based on the current session
function getDefaultAccountInfo(accounts){
  let defaultAccount = accounts.find ((item) => item.is_default);
  let accountId = defaultAccount.account_id;
  let baseUri =  `${defaultAccount.base_uri}${'/restapi'}`;
  return baseUri;
}

// Export the necessary modules from this library
module.exports = {
	'getDefaultAccountInfo': getDefaultAccountInfo
};