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
    return redirect('login');
});

Auth::routes();


Route::group(['middleware' => ['isLoggedIn']], function (){

    Route::resource('roster', 'RostersController');
    Route::resource('profile', 'ProfileController');

});

//User must be admin to access this.
Route::group(['middleware' => ['admin']], function () {
    Route::resource('admin', 'AdminController');
    //Creates new user
    Route::get('admin/new/user', 'AdminController@makeuser')->name('admin.newuser');
    Route::post('admin/create/user', 'AdminController@createuser')->name('admin.create.user');
    //User Roster Updates
    Route::get('admin/user/roster', 'AdminController@user_calendar')->name('admin.show_user');
    Route::get('admin/user/roster/{id}', 'AdminController@show_user_calendar')->name('admin.show_user_calendar');
    Route::post('admin/user/roster/{id}', 'AdminController@edit_user_calendar')->name('admin.edit_user_calendar');
});
