<?php

namespace Deserializers\Tests\Phpunit\Deserializers;

use Deserializers\TypedObjectDeserializer;

/**
 * @covers Deserializers\TypedObjectDeserializer
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TypedObjectDeserializerTest extends \PHPUnit\Framework\TestCase {

	private const DEFAULT_TYPE_KEY = 'objectType';
	private const DUMMY_TYPE_VALUE = 'someType';

	public function testGivenDefaultObjectKey_isDeserializerForReturnsTrue() {
		$serialization = $this->newStubSerializationWithTypeKey( self::DEFAULT_TYPE_KEY );
		$this->assertTrue( $this->newMockDeserializer()->isDeserializerFor( $serialization ) );
	}

	/**
	 * @param string $typeKey
	 * @return TypedObjectDeserializer
	 */
	private function newMockDeserializer( $typeKey = self::DEFAULT_TYPE_KEY ) {
		return $this->getMockForAbstractClass(
			TypedObjectDeserializer::class,
			[
				self::DUMMY_TYPE_VALUE,
				$typeKey
			]
		);
	}

	private function newStubSerializationWithTypeKey( $typeKey ) {
		return [ $typeKey => self::DUMMY_TYPE_VALUE ];
	}

	public function testGivenUnknownObjectKey_isDeserializerForReturnsFalse() {
		$serialization = $this->newStubSerializationWithTypeKey( 'someNonsenseTypeKey' );
		$this->assertFalse( $this->newMockDeserializer()->isDeserializerFor( $serialization ) );
	}

	public function testGivenSpecifiedObjectKey_isDeserializerForReturnsTrue() {
		$specifiedTypeKey = 'myAwesomeTypeKey';

		$serialization = $this->newStubSerializationWithTypeKey( $specifiedTypeKey );
		$deserializer = $this->newMockDeserializer( $specifiedTypeKey );
		$this->assertTrue( $deserializer->isDeserializerFor( $serialization ) );
	}

}
