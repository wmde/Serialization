<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\InvalidAttributeException;
use Exception;
use TypeError;

/**
 * @covers Deserializers\Exceptions\InvalidAttributeException
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Kreuz
 */
class InvalidAttributeExceptionTest extends \PHPUnit\Framework\TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$exception = new InvalidAttributeException( 'attribute', 'value' );

		$this->assertSame( 'attribute', $exception->getAttributeName() );
		$this->assertSame( 'value', $exception->getAttributeValue() );
		$this->assertSame( 'Attribute "attribute" with value "value" is invalid',
			$exception->getMessage() );
		$this->assertNull( $exception->getPrevious() );
	}

	public function testConstructorWithAllArguments() {
		$previous = new Exception( 'previous' );
		$exception = new InvalidAttributeException(
			'attribute', 'value', 'customMessage', $previous
		);

		$this->assertSame( 'attribute', $exception->getAttributeName() );
		$this->assertSame( 'value', $exception->getAttributeValue() );
		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

	public function testConstructorWithPreviousTypeError() {
		$previous = new TypeError( 'previous' );
		$exception = new InvalidAttributeException(
			'attribute', 'value', 'customMessage', $previous
		);

		$this->assertSame( 'attribute', $exception->getAttributeName() );
		$this->assertSame( 'value', $exception->getAttributeValue() );
		$this->assertSame( 'customMessage', $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

}
