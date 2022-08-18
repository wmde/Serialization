<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\MissingTypeException;
use Exception;
use TypeError;

/**
 * @covers Deserializers\Exceptions\MissingTypeException
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Kreuz
 */
class MissingTypeExceptionTest extends \PHPUnit\Framework\TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$exception = new MissingTypeException();

		$this->assertSame( '', $exception->getMessage() );
		$this->assertNull( $exception->getPrevious() );
	}

	public function testConstructorWithAllArguments() {
		$previous = new Exception( 'previous' );
		$exception = new MissingTypeException( 'customMessage', $previous );

		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

	public function testConstructorWithPreviousPreviousTypeError() {
		$previous = new TypeError( 'previous' );
		$exception = new MissingTypeException( 'customMessage', $previous );

		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

}
