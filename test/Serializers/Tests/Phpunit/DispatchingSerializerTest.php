<?php

namespace Serializers\Tests\Phpunit\Serializers;

use InvalidArgumentException;
use Serializers\DispatchableSerializer;
use Serializers\DispatchingSerializer;
use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @covers Serializers\DispatchingSerializer
 *
 * @group Serialization
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingSerializerTest extends \PHPUnit\Framework\TestCase {

	public function testConstructWithNoSerializers() {
		$serializer = new DispatchingSerializer( [] );

		$this->assertFalse( $serializer->isSerializerFor( 'foo' ) );
		$this->assertFalse( $serializer->isSerializerFor( null ) );

		$this->expectException( UnsupportedObjectException::class );

		$serializer->serialize( 'foo' );
	}

	public function testConstructWithInvalidArgumentsCausesException() {
		$this->expectException( InvalidArgumentException::class );
		new DispatchingSerializer( [ new \stdClass() ] );
	}

	public function testCanSerialize() {
		$subSerializer = $this->createMock( DispatchableSerializer::class );

		$subSerializer->expects( $this->exactly( 4 ) )
			->method( 'isSerializerFor' )
			->willReturnCallback( static function ( $value ) {
				return $value > 9000;
			} );

		$serializer = new DispatchingSerializer( [ $subSerializer ] );

		$this->assertFalse( $serializer->isSerializerFor( 0 ) );
		$this->assertFalse( $serializer->isSerializerFor( 42 ) );
		$this->assertTrue( $serializer->isSerializerFor( 9001 ) );
		$this->assertTrue( $serializer->isSerializerFor( 31337 ) );
	}

	public function testSerializeWithSerializableValues() {
		$subSerializer = $this->createMock( DispatchableSerializer::class );

		$subSerializer->expects( $this->any() )
			->method( 'isSerializerFor' )
			->willReturn( true );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->willReturn( 42 );

		$serializer = new DispatchingSerializer( [ $subSerializer ] );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
		$this->assertEquals( 42, $serializer->serialize( null ) );
	}

	public function testSerializeWithUnserializableValue() {
		$subSerializer = $this->createMock( DispatchableSerializer::class );

		$subSerializer->expects( $this->once() )
			->method( 'isSerializerFor' )
			->willReturn( false );

		$serializer = new DispatchingSerializer( [ $subSerializer ] );

		$this->expectException( UnsupportedObjectException::class );
		$serializer->serialize( 0 );
	}

	public function testSerializeWithMultipleSubSerializers() {
		$subSerializer0 = $this->createMock( DispatchableSerializer::class );

		$subSerializer0->expects( $this->any() )
			->method( 'isSerializerFor' )
			->willReturn( true );

		$subSerializer0->expects( $this->any() )
			->method( 'serialize' )
			->willReturn( 42 );

		$subSerializer1 = $this->createMock( DispatchableSerializer::class );

		$subSerializer1->expects( $this->any() )
			->method( 'isSerializerFor' )
			->willReturn( false );

		$subSerializer2 = clone $subSerializer1;

		$serializer = new DispatchingSerializer( [ $subSerializer1, $subSerializer0, $subSerializer2 ] );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
	}

	public function testAddSerializer() {
		$serializer = new DispatchingSerializer( [] );

		$subSerializer = $this->createMock( DispatchableSerializer::class );

		$subSerializer->expects( $this->any() )
			->method( 'isSerializerFor' )
			->willReturn( true );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->willReturn( 42 );

		$serializer->addSerializer( $subSerializer );

		$this->assertEquals(
			42,
			$serializer->serialize( null )
		);
	}

}
