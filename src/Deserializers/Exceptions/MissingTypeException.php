<?php

namespace Deserializers\Exceptions;

/**
 * Indicates the objectType key is missing in the serialization.
 *
 * @since 1.0
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MissingTypeException extends DeserializationException {

  public function __construct( $message = '', \Exception $previous = null ) {
    if ( $message === '' ) {
      $message = 'Type is missing';
    }
		parent::__construct( $message, $previous );
	}
}
