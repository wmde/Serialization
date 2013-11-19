<?php

namespace Serializers;

use InvalidArgumentException;
use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingSerializer implements Serializer {

	/**
	 * @var Serializer[]
	 */
	protected $serializers;

	/**
	 * @param Serializer[] $serializers
	 */
	public function __construct( array $serializers = array() ) {
		$this->assertAreSerializers( $serializers );
		$this->serializers = $serializers;
	}

	protected function assertAreSerializers( array $serializers ) {
		foreach ( $serializers as $serializer ) {
			if ( !( $serializer instanceof Serializer ) ) {
				throw new InvalidArgumentException( 'Got an object that is not an instance of Serializers\Serializer' );
			}
		}
	}

	public function serialize( $object ) {
		foreach ( $this->serializers as $serializer ) {
			if ( $serializer->isSerializerFor( $object ) ) {
				return $serializer->serialize( $object );
			}
		}

		throw new UnsupportedObjectException( $object );
	}

	public function isSerializerFor( $object ) {
		foreach ( $this->serializers as $serializer ) {
			if ( $serializer->isSerializerFor( $object ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @since 1.0
	 *
	 * @param Serializer $serializer
	 */
	public function addSerializer( Serializer $serializer ) {
		$this->serializers[] = $serializer;
	}

}
