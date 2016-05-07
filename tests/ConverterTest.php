<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Libraries\Converter;

class ConverterTest extends TestCase {
	use DatabaseTransactions;

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testExample() {
		$tests     = array(
			1      => 'I',
			5      => 'V',
			10     => 'X',
			20     => 'XX',
			369    => 'CCCLXIX',
			3999   => 'MMMCMXCIX',
			5000   => false,
			'ABCD' => false
		);

		$converter = new Converter();

		foreach ( $tests as $number => $roman ) {
			$this->assertEquals( $roman, $converter->toRomanNumerals( $number ) );

			$this->visit( '/' )
			     ->type( $number, 'number' )
			     ->press( 'Submit' );
		}
	}
}
