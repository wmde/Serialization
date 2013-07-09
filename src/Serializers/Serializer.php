<?php

namespace Serializers;

/**
 * @since 1.0
 *
 * @file
 * @ingroup Deserialization
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Serializer {

	/**
	 * @since 1.0
	 *
	 * @param mixed $object
	 *
	 * @return array|int|string|bool|float A possibly nested structure consisting of only arrays and scalar values
	 */
	public function serialize( $object );

	/**
	 * @since 1.0
	 *
	 * @param mixed $object
	 *
	 * @return boolean
	 */
	public function canSerialize( $object );

}
