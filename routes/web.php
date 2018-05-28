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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
* Admin Routes
*/
// Admin Home
Route::get('admin/home','AdminController@index');
Route::group(['middleware'=>'guest:admin','prefix'=>'admin','namespace'=>'Admin'],function(){

	//Admin Login and Logout 
	Route::get('login','LoginController@showLoginForm')->name('admin.login');
	Route::post('login','LoginController@login');
	Route::post('logout','LoginController@logout')->name('admin.logout');

	// Admin Register
	Route::get('register','RegisterController@showRegistrationForm')->name('admin.register');
	Route::post('register','RegisterController@register');

	// Admin Reset Password
	Route::post('reset/email','ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('reset/password','ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('reset/password','ResetPasswordController@reset');
	Route::get('reset/password/{token}','ResetPasswordController@showResetForm')->name('admin.password.reset');
});


// Admin Verify Account
Route::get('verify/{email}/{verify_token}','Admin\RegisterController@verifyRegistrationEmail')->name('verifyEmail');

Route::get('admin/subscriber','SubscriberController@index');