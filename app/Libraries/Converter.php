<?php
/**
 * Author: Paweł Derehajło
 * Contact: derehajlo@gmail.com
 * Date: 07/05/16
 */

namespace App\Libraries;

use App\Libraries;
use Illuminate\Validation\Factory as ValidatorFactory;
use Symfony\Component\Translation\Translator;

class Converter implements IntegerConversion {

	public function convert( $number ) {
		$factory = new ValidatorFactory(new Translator('en'));
		$validation = $factory->make(
			array(
				'number' => $number
			),
			array(
				'number' => array( 'required', 'numeric', 'min:0', 'max:3999' )
			)
		);

		if ( $validation->fails() ) {
			return false;
		}

		return $this->toRomanNumerals( $number );
	}

	public function toRomanNumerals( $number ) {
		$result = '';
		$number = (int) $number;

		// numbers below zero don't exist
		if ( $number <= 0 ) {
			return false;
		}

		$dictionary = array(
			1    => 'I',
			5    => 'V',
			10   => 'X',
			50   => 'L',
			100  => 'C',
			500  => 'D',
			1000 => 'M'
		);

		// end early if key exists
		if ( array_key_exists( $number, $dictionary ) ) {
			return $dictionary[ $number ];
		}

		$temp = 0;

		for ( $i = 1000; (int) $i !== 0; $i /= 10 ) {
			$part = $number - ( (int) $number % $i ) - $temp;

			if ( $i > $number || $part == 0 ) {
				continue;
			}

			$closest = $this->closest( $dictionary, $part );
			if ( $closest < $part ) {
				$repeat = floor( $part / $closest );
				$result .= str_repeat( $dictionary[ $closest ], $repeat );

				$after = $this->toRomanNumerals( $part - ( $closest * $repeat ) );
				if ( $after ) {
					$result .= $after;
				}
			} else {
				$before = $this->toRomanNumerals( $closest - $part );
				if ( $before ) {
					$result .= $before;
				}

				$result .= $dictionary[ $closest ];
			}

			$temp += $part;
		}

		return $result;
	}

	function closest( $array, $number ) {
		$ratio = 0.8;
		end( $array );
		$next = key( $array );
		reset( $array );
		$prev = key( $array );

		foreach ( $array as $key => $val ) {
			if ( $key > $number ) {
				$next = $key;
				break;
			}
			$prev = $key;
		}

		if ( $number / $next > $ratio ) {
			return $next;
		}

		return $prev;
	}
}