<?php

namespace Deserializers\Tests\Phpunit\Deserializers;

use Deserializers\DispatchableDeserializer;
use Deserializers\DispatchingDeserializer;
use Deserializers\Exceptions\DeserializationException;
use InvalidArgumentException;

/**
 * @covers Deserializers\DispatchingDeserializer
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstructWithNoDeserializers() {
		new DispatchingDeserializer( [] );
		$this->assertTrue( true );
	}

	public function testCannotConstructWithNonDeserializers() {
		$this->setExpectedException( InvalidArgumentException::class );
		new DispatchingDeserializer( [ 42, 'foobar' ] );
	}

	public function testCanDeserialize() {
		$subDeserializer = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer->expects( $this->exactly( 4 ) )
			->method( 'isDeserializerFor' )
			->will( $this->returnCallback( function( $value ) {
				return $value > 9000;
			} ) );

		$serializer = new DispatchingDeserializer( [ $subDeserializer ] );

		$this->assertFalse( $serializer->isDeserializerFor( 0 ) );
		$this->assertFalse( $serializer->isDeserializerFor( 42 ) );
		$this->assertTrue( $serializer->isDeserializerFor( 9001 ) );
		$this->assertTrue( $serializer->isDeserializerFor( 31337 ) );
	}

	public function testDeserializeWithDeserializableValues() {
		$subDeserializer = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer->expects( $this->any() )
			->method( 'isDeserializerFor' )
			->will( $this->returnValue( true ) );

		$subDeserializer->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$serializer = new DispatchingDeserializer( [ $subDeserializer ] );

		$this->assertEquals( 42, $serializer->deserialize( 'foo' ) );
		$this->assertEquals( 42, $serializer->deserialize( null ) );
	}

	public function testSerializeWithUnserializableValue() {
		$subDeserializer = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer->expects( $this->once() )
			->method( 'isDeserializerFor' )
			->will( $this->returnValue( false ) );

		$serializer = new DispatchingDeserializer( [ $subDeserializer ] );

		$this->setExpectedException( DeserializationException::class );
		$serializer->deserialize( 0 );
	}

	public function testSerializeWithMultipleSubSerializers() {
		$subDeserializer0 = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer0->expects( $this->any() )
			->method( 'isDeserializerFor' )
			->will( $this->returnValue( true ) );

		$subDeserializer0->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$subDeserializer1 = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer1->expects( $this->any() )
			->method( 'isDeserializerFor' )
			->will( $this->returnValue( false ) );

		$subDeserializer2 = clone $subDeserializer1;

		$serializer = new DispatchingDeserializer( [
			$subDeserializer1,
			$subDeserializer0,
			$subDeserializer2,
		] );

		$this->assertEquals( 42, $serializer->deserialize( 'foo' ) );
	}

	public function testAddSerializer() {
		$deserializer = new DispatchingDeserializer( [] );

		$subDeserializer = $this->getMock( DispatchableDeserializer::class );

		$subDeserializer->expects( $this->any() )
			->method( 'isDeserializerFor' )
			->will( $this->returnValue( true ) );

		$subDeserializer->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$deserializer->addDeserializer( $subDeserializer );

		$this->assertEquals(
			42,
			$deserializer->deserialize( null )
		);
	}

}
