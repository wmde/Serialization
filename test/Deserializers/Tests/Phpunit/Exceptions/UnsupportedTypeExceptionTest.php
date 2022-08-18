<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\UnsupportedTypeException;
use Exception;
use TypeError;

/**
 * @covers Deserializers\Exceptions\UnsupportedTypeException
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Kreuz
 */
class UnsupportedTypeExceptionTest extends \PHPUnit\Framework\TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$exception = new UnsupportedTypeException( 'type' );

		$this->assertSame( 'type', $exception->getUnsupportedType() );
		$this->assertSame( 'Type "type" is unsupported', $exception->getMessage() );
		$this->assertNull( $exception->getPrevious() );
	}

	public function testConstructorWithAllArguments() {
		$previous = new Exception( 'previous' );
		$exception = new UnsupportedTypeException( 'type', 'customMessage', $previous );

		$this->assertSame( 'type', $exception->getUnsupportedType() );
		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

	public function testConstructorWithPreviousTypeError() {
		$previous = new TypeError( 'previous' );
		$exception = new UnsupportedTypeException( 'type', 'customMessage', $previous );

		$this->assertSame( 'type', $exception->getUnsupportedType() );
		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

}
