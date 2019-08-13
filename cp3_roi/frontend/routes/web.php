<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/login', function() {
	return view('/users/login');
});

Route::get('/users/register', function() {
	return view('/users/register');
});

Route::get('/users/editProfile', function() {
	return view('/users/editProfile');
});

Route::get('/users/deleteUserProfiles', function() {
	return view('/users/deleteUserProfiles');
});

Route::get('/availabilities/{id}', function($id) {
	return view('/availabilities/book', compact('id'));
});

Route::get('/admin', function() {
	return view('/users/admin');
});

Route::get('/availabilities/update/{id}', function($id) {
	return view('/availabilities/update', compact('id'));
});

Route::get('/admin/transactions', function() {
	return view('/transactions/adminView');
});

Route::get('/transactions/{id}', function($id) {
	return view('/transactions/guestView', compact('id'));
});