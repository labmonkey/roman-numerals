<?php
/**
 * Author: Paweł Derehajło
 * Contact: derehajlo@gmail.com
 * Date: 07/05/16
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\History;
use Illuminate\Http\Request;
use App\Libraries\Converter;

class HistoryController extends BaseController {
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	function convert( Request $request ) {
		$this->validate( $request, [
			'number' => 'required|numeric|min:0|max:3999',
		] );

		$history         = new History;
		$history->number = $request->number;
		$history->save();

		return redirect( route( 'home', array( 'number' => $request->number ) ) );
	}
}