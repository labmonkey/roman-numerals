<?php
/**
 * Author: Paweł Derehajło
 * Contact: derehajlo@gmail.com
 * Date: 07/05/16
 */

namespace App\Libraries;

use App\Libraries;

class Converter implements IntegerConversion {
	public function toRomanNumerals( $number ) {
		$dictionary = array(
			1    => 'I',
			5    => 'V',
			10   => 'X',
			50   => 'L',
			100  => 'C',
			500  => 'D',
			1000 => 'M'
		);

		$roman = "I";

		return $roman;
	}
}