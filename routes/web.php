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

Route::get('/fir/weather', function() {
    return view('test.fir_flight');
});

Route::get('passwordgen/{id}', 'PasswordGen@index')->name('password');

Auth::routes(['verify' => true, 'register' => false]);

Route::get('weather', 'MetarController@metar')->name('test.weather');
Route::get('flight', 'MetarController@flight')->name('test.flight');


Route::group(['middleware' => ['isLoggedIn']], function (){

    Route::resource('roster', 'RostersController');
    Route::resource('profile', 'ProfileController');

    Route::get('teams/myteam', 'TeamsController@myteam')->name('team.myteam');

});

//User must be admin to access this.
Route::group(['middleware' => ['admin']], function () {
    
    //Create Block Roster
    Route::get('admin/block', 'AdminController@block')->name('admin.block');
    Route::post('admin/create/block/', 'AdminController@create_block')->name('admin.create_block');
   
    //Creates new user
    Route::get('admin/new/user', 'AdminController@makeuser')->name('admin.newuser');
    Route::post('admin/create/user', 'AdminController@createuser')->name('admin.create.user');

    //Update User Route
    //This route needs to be changed to admin/user and remove update from the middle
    Route::get('admin/update/user', 'AdminController@select_user_profile')->name('admin.select_user_profile');
    Route::get('admin/update/user/{admin}', 'AdminController@view_user_profile')->name('admin.view_user_profile');
    Route::patch('admin/update/user/{admin}/update', 'AdminController@update_user_profile')->name('admin.update_user_profile');

    //User Roster Updates
    Route::get('admin/user/roster', 'AdminController@user_calendar')->name('admin.show_user');
    Route::get('admin/user/roster/{admin}', 'AdminController@show_user_calendar')->name('admin.show_user_calendar');
    Route::get('admin/user/roster/{admin}/edit', 'AdminController@edit_user_calendar')->name('admin.edit_user_calendar');
    Route::patch('admin/user/roster/{admin}/update', 'AdminController@update_user_calendar')->name('admin.update_user_calendar');
    Route::patch('admin/user/roster/{admin}/delete', 'AdminController@delete_day_from_user_calendar')->name('admin.delete_day_from_user_calendar');
    
    Route::patch('admin/user/roster/{admin}/delete/all', 'AdminController@delete_user_roster')->name('admin.delete_user_roster');

    Route::resource('admin', 'AdminController');
    
    //Teams Routes
    Route::resource('teams', 'TeamsController');

    //Timing Routes
    Route::resource('timing', 'TimingController');

    Route::get('missingtimes', 'AdminController@missingtimes')->name('missingtimes.index');

    Route::get('email/lastedited/{id}', 'EmailController@lastedited')->name('email.lastedited');

});

Route::get('airport/{id}', 'MetarController@airport');
Route::get('fir/{id}', 'MetarController@fir_highlight');

Route::get('youtube/{id}', 'HomeController@youtube');
Route::get('youtube/channel/{id}', 'HomeController@videos');