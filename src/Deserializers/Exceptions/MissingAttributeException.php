<?php

namespace Deserializers\Exceptions;

use Exception;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Mättig
 */
class MissingAttributeException extends DeserializationException {

	protected $attributeName;

	/**
	 * @param string $attributeName
	 * @param string $message
	 * @param Exception|null $previous
	 */
	public function __construct( $attributeName, $message = '', Exception $previous = null ) {
		$this->attributeName = $attributeName;

		if ( $message === '' ) {
			$message = 'Attribute "' . $attributeName . '" is missing';
		}

		parent::__construct( $message, $previous );
	}

	/**
	 * @return string
	 */
	public function getAttributeName() {
		return $this->attributeName;
	}

}
