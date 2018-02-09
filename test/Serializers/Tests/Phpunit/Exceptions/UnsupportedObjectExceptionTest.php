<?php

namespace Serializers\Tests\Phpunit\Exceptions;

use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @covers Serializers\Exceptions\UnsupportedObjectException
 *
 * @group Serialization
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedObjectExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$object = [ 'the' => 'game' ];

		$exception = new UnsupportedObjectException( $object );

		$this->assertRequiredFieldsAreSet( $exception, $object );
	}

	public function testConstructorWithAllArguments() {
		$object = [ 'the' => 'game' ];
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedObjectException( $object, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $object );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	private function assertRequiredFieldsAreSet( UnsupportedObjectException $exception, $object ) {
		$this->assertEquals( $object, $exception->getUnsupportedObject() );
	}

}
