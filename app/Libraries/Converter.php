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
		$result = false;
		if ( $number < 0 ) {
			return $result;
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

		if ( array_key_exists( $number, $dictionary ) ) {
			return $dictionary[ $number ];
		}

		$number = (int) $number;
		$temp   = 0;

		for ( $i = 1000; (int) $i !== 0; $i /= 10 ) {
			$roman = $number - $number % $i - $temp;
			$key   = $this->next( $dictionary, $roman );
			if ( ( $part = $roman / $key ) < 0.8 ) {
				$key = $this->prev( $dictionary, $roman );
				$result .= str_repeat( $dictionary[ $key ], $roman / $key );
				if ( $roman - $key < $key ) {
					$result .= $this->toRomanNumerals( $roman - $key );
				}
			} else {
				if ( $part !== 1 ) {
					$prev = $this->prev( $dictionary, $roman );
					if ( $roman < 10 ) {
						$prev = 1;
					}
					$result .= $dictionary[ $prev ];
				}
				$result .= $dictionary[ $key ];
			}

			$temp += $roman;
		}

		//3999
		//MMDMLCIX
		//MMMCMXCIX
		return $result;
	}

	function prev( $array, $number ) {
		$array = array_reverse( $array, true );
		foreach ( $array as $k => $a ) {
			if ( $k <= $number ) {
				return $k;
			}
		}

		end( $array );

		return key( $array );
	}

	function next( $array, $number ) {
		foreach ( $array as $k => $a ) {
			if ( $k >= $number ) {
				return $k;
			}
		}

		end( $array );

		return key( $array );
	}
}