const mongoose = require('mongoose');

//load jsonwebtoken for authentication
const jwt = require('jsonwebtoken');

const Schema = mongoose.Schema;

const UserSchema = new Schema({
	name: String,
	userName: String,
	email: String,
	password: String,
	isAdmin: {type: Boolean, default: false} 
});

//adds a JWT generation method to the Schema
UserSchema.methods.generateJWT = function() {
	const today = new Date();
	const expirationDate = new Date(today);
	//add a 60 minute expiration to the JWT
	expirationDate.setDate(today.getDate() + 60);

	return jwt.sign({
		email: this.email,
		id: this._id,
		exp: parseInt(expirationDate.getTime() / 1000, 10)
	}, 'secret');
}

//add a JSON generation method to the schema
UserSchema.methods.toAuthJSON = function() {
	return {
		_id: this._id,
		email: this.email,
		token: this.generateJWT()
	};
};

//Set up the user model and export it to the 
module.exports = mongoose.model('User', UserSchema);