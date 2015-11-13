<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\UnsupportedTypeException;
use Exception;
use PHPUnit_Framework_TestCase;

/**
 * @covers Deserializers\Exceptions\UnsupportedTypeException
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Mättig
 */
class UnsupportedTypeExceptionTest extends PHPUnit_Framework_TestCase {

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

}
