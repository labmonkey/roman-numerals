<?php
/**
 * Author: Paweł Derehajło
 * Contact: derehajlo@gmail.com
 * Date: 07/05/16
 */

namespace App\Http\Controllers;

use App\Libraries\Converter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\History;
use Illuminate\Http\Request;

class HomeController extends BaseController {
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	function index( Request $request ) {
		$history = History::orderBy( 'created_at', 'desc' )->get();

		$data = array(
			'history' => $history
		);

		if ( $request->number ) {
			$converter      = new Converter();
			$data['number'] = $request->number;
			$data['roman']  = $converter->toRomanNumerals( $request->number );
		}

		return view( 'converter', $data );
	}
}