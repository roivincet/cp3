// Export configuration variables
module.exports = {

	// Establish the port where the application will be run on
	'port': process.env.PORT || 3000,
	
	// App secret key
	'secretKey': process.env.SECRET_KEY || 'MELN Project',

	// Database URL
	'databaseURL': process.env.DATABASE_URL || 'mongodb://127.0.0.1:27017/melnbooking',
	
	// Establish salt rounds
	'saltRounds': 10,

	// Stripe secret key
	'stripeSecretKey': process.env.STRIPE_SECRET_KEY || 'sk_test_PJl8sU6NGCVwL9ktYE2WYzND',

};