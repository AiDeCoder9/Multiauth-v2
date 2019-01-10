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

Auth::routes(['verify' => true]);




Route::get('admin/email/resend','Admin\VerificationController@resend')->name('admin.verification.resend');
Route::get('admin/email/verify','Admin\VerificationController@show')->name('admin.verification.notice');
Route::get('admin/email/verify/{id}','Admin\VerificationController@verify')->name('admin.verification.verify');


Route::get('admin/dashboard','AdminController@index')->name('admin.dashboard')->middleware('adminVerified');
Route::get('admin','Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin','Admin\LoginController@login');

Route::get('admin/register','Admin\RegisterController@showRegistrationForm')->name('admin.register');
Route::post('admin/register','Admin\RegisterController@register')->name('admin.register');


Route::post('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/reset','Admin\ResetPasswordController@reset');
Route::get('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::get('admin/logout','Admin\LoginController@logout')->name('admin.logout');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');;


;
