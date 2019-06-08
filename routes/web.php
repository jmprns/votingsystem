
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

/**
* Administrator Routes.
* This group handles all the url of administrative controlls
*
*/

Route::get('dashboard', 'DashboardController@index');

// Election Route
Route::prefix('election')->group(function(){

	Route::get('/', 'ElectionController@index');
	Route::post('/add', 'ElectionController@create');
	Route::get('/show/{id}', 'ElectionController@show');

	// Position Route
	Route::prefix('position')->group(function(){
		Route::get('/{id}', 'PositionController@create');
		Route::post('/', 'PositionController@store');
	});

	// Candidate Route
	Route::prefix('candidate')->group(function(){
		Route::get('/{eid}/{vid}', 'CandidateController@create');
		Route::post('/add', 'CandidateController@store');
	});

	Route::prefix('result')->group(function(){
		Route::get('/{id}', 'ResultController@index');
	});


});

// Party Route
Route::prefix('party')->group(function(){
	Route::get('/', 'PartyController@index');
	Route::post('/add', 'PartyController@store');
});



// Voters Route
Route::prefix('voters')->group(function(){
	Route::get('/', 'VoterController@index');
	Route::get('/add', 'VoterController@create');
	Route::post('/add', 'VoterController@store');
	Route::get('/delete/{id}', 'VoterController@destroy');
});



/**
* Ballot Routes.
* This group handles all the url of ballot where users can vote
*
*/

Route::prefix('ballot')->group(function(){
	Route::get('/', 'BallotController@login');
	Route::post('/', 'BallotController@form');
	Route::post('/review', 'BallotController@review');
	Route::post('/cast/{vid}', 'BallotController@cast');
	Route::get('/handler', 'BallotController@handler');
});




