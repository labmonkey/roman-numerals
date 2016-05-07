<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\History;
use Illuminate\Http\Request;

Route::get( '/', function () {
	$history = History::orderBy( 'created_at', 'asc' )->get();

	return view( 'converter', [
		'history' => $history
	] );
} );


/**
 * Add New History
 */
Route::post( '/history', function ( Request $request ) {
	$validator = Validator::make( $request->all(), [
		'number' => 'required|numeric|min:0|max:3999',
	] );

	if ( $validator->fails() ) {
		return redirect( '/' )
			->withInput()
			->withErrors( $validator );
	}

	$history         = new History;
	$history->number = $request->number;
	$history->save();

	return redirect( '/' );
} );