<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\DeserializationException;
use Exception;
use TypeError;

/**
 * @covers Deserializers\Exceptions\DeserializationException
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Kreuz
 */
class DeserializationExceptionTest extends \PHPUnit\Framework\TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$exception = new DeserializationException();

		$this->assertSame( '', $exception->getMessage() );
		$this->assertNull( $exception->getPrevious() );
	}

	public function testConstructorWithAllArguments() {
		$previous = new Exception( 'previous' );
		$exception = new DeserializationException( 'customMessage', $previous );

		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

	public function testConstructorWithPreviousTypeError() {
		$previous = new TypeError( 'previous' );
		$exception = new DeserializationException( 'customMessage', $previous );

		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

}
