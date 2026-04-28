<?php

namespace AccessibilityChecker\Exceptions;

use AccessibilityChecker\IdentifierType;
use Exception;
use Throwable;

class InvalidIdentifierTypeException extends Exception{

    const code = 500;

    public $identifier_type;

    public function __construct(string $identifier_type, ?Throwable $previous = null) {
        
        $this->identifier_type = $identifier_type;

        $message = "Invalid identifier type: " . $identifier_type . ". Expected from: " . IdentifierType::cases();

        parent::__construct($message, $this::code, $previous);

    }

}

?>