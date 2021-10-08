<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


Route::get('/', function () {
    return redirect('/ballot');
});

Route::get('/logging', 'LogController@index');


Route::get('/ballot/logout', 'Auth\LoginController@userLogout');

Route::prefix('ballot')->group(function () {
	Route::get('/', 'BallotController@index');
	Route::get('/redirect', 'BallotController@page');
	Route::post('/cast', 'BallotController@cast');
	Route::post('/review', 'BallotController@review');
});

Route::prefix('admin')->group(function (){
	
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
	Route::get('/', function() {return redirect('/admin/dashboard');});
	Route::get('/logout', 'Auth\AdminLoginController@adminLogout');
	
	//Dashboard Route
	Route::get('/dashboard', 'Admin\DashboardController@index');

	// Election Route
	Route::prefix('election')->group(function () {

		// Election Root
		Route::get('/', 'Admin\ElectionController@index');
		Route::post('/store', 'Admin\ElectionController@store');
		Route::post('/update', 'Admin\ElectionController@update');
		Route::get('/delete/{id}', 'Admin\ElectionController@destroy');
		Route::get('/show/{id}', 'Admin\ElectionController@show');

		Route::get('/voter/add/{id}', 'Admin\ElectionController@voter');

		// Precinct Route
		Route::get('/precinct/show/{id}', 'Admin\PrecinctController@index');

		// Position Route
		Route::get('/position/add/{id}', 'Admin\PositionController@create');
		Route::post('/position/store', 'Admin\PositionController@store');
		Route::get('/position/edit/{id}', 'Admin\PositionController@edit');
		Route::post('/position/update/{id}', 'Admin\PositionController@update');
		Route::post('/position/delete/{id}', 'Admin\PositionController@destroy');

		// Candidate Route
		Route::get('/candidate/add/{id}/{vid}', 'Admin\CandidateController@create');
		Route::get('/candidate/edit/{id}', 'Admin\CandidateController@edit');
		Route::post('/candidate/store', 'Admin\CandidateController@store');
		Route::post('/candidate/update', 'Admin\CandidateController@update');
		Route::post('/candidate/delete', 'Admin\CandidateController@destroy');

		// Result Route
		Route::get('/result/{id}', 'Admin\ResultController@index');
		Route::post('/result/', 'Admin\ResultController@send');
		Route::get('/result/generate/all/{id}', 'Admin\ResultController@all');
		Route::get('/result/generate/win/{id}', 'Admin\ResultController@win');

	});

	// Party Route

	Route::prefix('partylist')->group(function (){
		Route::get('/', 'Admin\PartylistController@index');
		Route::get('/member/{id}', 'Admin\PartylistController@show');
		Route::post('/store', 'Admin\PartylistController@store');
		Route::post('/update/{id}', 'Admin\PartylistController@update');
		Route::post('/delete/{id}', 'Admin\PartylistController@destroy');
	});

	// Voter Route
	Route::prefix('voters')->group(function (){
		Route::get('/', 'Admin\VoterController@index');
		Route::get('/print', 'Admin\VoterController@print');
		Route::get('/add', 'Admin\VoterController@create');
		Route::get('/edit/{id}', 'Admin\VoterController@edit');
		Route::post('/store', 'Admin\VoterController@store');
		Route::post('/update/{id}', 'Admin\VoterController@update');
		Route::post('/destroy/{id}', 'Admin\VoterController@destroy');
		Route::post('/action', 'Admin\VoterController@action');
	});

	// Setting Route
	Route::prefix('settings')->group(function () {
		Route::get('/', 'Admin\SettingController@index');
		Route::post('/', 'Admin\SettingController@settings');
		Route::get('/add-admin', 'Admin\SettingController@admin');
		
	});

	Route::prefix('log')->group(function () {
		Route::get('/votes', 'Admin\LogController@votes');
		Route::get('/voter', 'Admin\LogController@voter');
		Route::get('/admin', 'Admin\LogController@admin');
		Route::get('/activity', 'Admin\LogController@activity');
	});
	
});