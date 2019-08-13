const express = require('express');

const router = express.Router();

const UserModel = require('../models/User');

const bcrypt = require('bcrypt-nodejs');

//registration endpoint
router.post('/register', (req,res) => {
	let name = req.body.name;
	let userName = req.body.userName;
	let email = req.body.email;
	let password = req.body.password;

	if(!email || !password) {
		return res.status(500).json({
			'error' : 'incomplete'
		});
	}


	UserModel.find({'email' : email})
		.then((users, err) => {
			if(err) {
				return res.status(500).json({
					'error' : err
				});
			}

			if(users.length > 0) {
				return res.status(500).json({
					'error' : 'user already exists'
				});
			}

			bcrypt.genSalt(10, function(err, salt) {
				bcrypt.hash(password, salt, null, function(err, hash) {
					let newUser = UserModel({
						'name' : name,
						'userName' : userName,
						'email' : email,
						'password' : hash
					});

					newUser.save(err => {
						if(!err) {
							return res.json({
								'message' : 'User registered successfully'
							});
						}
					});
				});
			});
		});

});

		//RETRIEVE A SINGLE USER
router.get('/user/:id', (req, res) => {
    // console.log(req.params)
    UserModel.findOne({_id : req.params.id})
    .then( user => {
        console.log(user)
        if(user) {
            return res.json({
                'data' : {
                    'user' : user
                }
            })
        }

        return res.json({
            'message' : 'no user with the given id'
        })
    } )
})


router.put('/edit/:id', (req, res, next) => {
    // console.log(req.body)
    // res.send({type: 'PUT'});
    UserModel.updateOne({_id : req.params.id }, req.body)
    .then( ()=> {
        UserModel.findOne({_id : req.params.id})
            .then(user => {
                res.send(user)
            })
    }).catch(next)
})


// delete single user
router.delete('/:id', (req, res, next) => {
    // res.send({type : 'DELETE'});
    UserModel.deleteOne({_id : req.params.id })
    .then(user => {
        res.send(user)
    }).catch(next)
})


module.exports = router;