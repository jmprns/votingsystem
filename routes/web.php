
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

Route::get('/home', function () {
    return redirect('/election');
});
/**
* Administrator Routes.
* This group handles all the url of administrative controlls
*
*/


// Election Route
Route::prefix('election')->group(function(){

	Route::get('/', 'ElectionController@index');
	Route::post('/add', 'ElectionController@create');
	Route::get('/show/{id}', 'ElectionController@show');

	// Position Route
	Route::prefix('position')->group(function(){
		Route::get('/{id}', 'PositionController@create');
		Route::post('/', 'PositionController@store');
		Route::get('/delete/{id}', 'PositionController@destroy');
		Route::get('/edit/{id}', 'PositionController@edit');
		Route::post('/update/{id}', 'PositionController@update');
	});

	// Candidate Route
	Route::prefix('candidate')->group(function(){
		Route::get('/destroy/{id}', 'CandidateController@destroy');
		Route::get('/edit/{id}', 'CandidateController@edit');
		Route::get('/{eid}/{vid}', 'CandidateController@create');
		Route::post('/add', 'CandidateController@store');
		Route::post('/update/{id}', 'CandidateController@update');
	});

	Route::prefix('result')->group(function(){
		Route::get('/{id}', 'ResultController@index');
		Route::get('/print/{id}/all', 'ResultController@printAll');
		Route::get('/print/{id}/winner', 'ResultController@printWinner');
	});

	// Voters Route
	Route::prefix('voters')->group(function(){
		Route::get('/add/{id}', 'VoterController@create');
		Route::post('/add', 'VoterController@store');
		Route::get('/delete/{id}', 'VoterController@destroy');
		Route::get('/edit/{id}', 'VoterController@edit');
		Route::post('/update/{id}', 'VoterController@update');
	});


});

// Party Route
Route::prefix('party')->group(function(){
	Route::get('/', 'PartyController@index');
	Route::post('/add', 'PartyController@store');
	Route::get('/delete/{id}', 'PartyController@destroy');
	Route::post('/update', 'PartyController@update');
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




