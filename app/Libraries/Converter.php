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

	/*
	 * Validate and convert
	 */
	public function convert( $number ) {
		// standalone validator with default settings
		$factory    = new ValidatorFactory( new Translator( 'en' ) );
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

	/*
	 * Convert number into roman numeral
	 */
	public function toRomanNumerals( $number ) {
		$result = '';
		$number = (int) $number;

		// numbers below zero don't exist
		if ( $number <= 0 ) {
			return false;
		}

		// Dictionary contains only the basic numbers and the
		// rest is calculated basing on it
		$dictionary = array(
			1    => 'I',
			5    => 'V',
			10   => 'X',
			50   => 'L',
			100  => 'C',
			500  => 'D',
			1000 => 'M'
		);

		// end early if key already exists
		if ( array_key_exists( $number, $dictionary ) ) {
			return $dictionary[ $number ];
		}

		// used for $part calculation (more description in loop)
		$temp = 0;

		/*
		 * The idea here is to split numbers into chunks so for ex. '1345' becomes 1000, 300, 40, 5
		 * and then each chunk is looked up in dictionary.
		 */
		for ( $i = 1000; (int) $i !== 0; $i /= 10 ) {
			// current chunk is the difference of given number, $i
			// and sum of previous chunks from the loop
			$part = $number - ( (int) $number % $i ) - $temp;

			// don't calculate when it's not needed
			// for ex. 45 doesn't need '1000' chunk
			// and when there are no chunks left we can break
			if ( $i > $number || $part == 0 ) {
				continue;
			}

			$closest = $this->closest( $dictionary, $part );

			// either number is closer to prev character in dictionary or to next one
			if ( $closest < $part ) {
				// numbers that are lower can have repeated character ( like I, II, III)
				$repeat = floor( $part / $closest );
				$result .= str_repeat( $dictionary[ $closest ], $repeat );

				// should there be something appended (like to V : VI, VII)
				$after = $this->toRomanNumerals( $part - ( $closest * $repeat ) );
				if ( $after ) {
					$result .= $after;
				}
			} else {
				// should there be something prepended (like to V : IV)
				$before = $this->toRomanNumerals( $closest - $part );
				if ( $before ) {
					$result .= $before;
				}

				$result .= $dictionary[ $closest ];
			}

			// sum of all previous chunks
			$temp += $part;
		}

		return $result;
	}

	function closest( $array, $number ) {
		/*
		 * This ratio was taken from the overall idea how roman numbers work.
		 * For ex. after I there are 2 numbers that append it and before V there is one that prepends is.
		 * It works same way for all other roman letters/numbers. The point at which this 'switch' happens
		 * is exactly after third of all numbers (I, II, III, IV, V) so it happens at fourth of 5 numbers.
		 * It's position is 4/5 which translates into 0.8.
		 */
		$ratio = 0.8;

		// get the last and first element of array
		end( $array );
		$next = key( $array );
		reset( $array );
		$prev = key( $array );

		// this way we know which element is before and after the given number
		foreach ( $array as $key => $val ) {
			if ( $key > $number ) {
				$next = $key;
				break;
			}
			$prev = $key;
		}

		// if the number is closer to the next roman number (IV closer to V)
		if ( $number / $next >= $ratio ) {
			return $next;
		}

		// number was closer to previous number (II, III closer to I)
		return $prev;
	}
}