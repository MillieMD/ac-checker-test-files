<?php

namespace AccessibilityChecker\Exceptions;

use Exception;
use Throwable;

class NullResourceException extends Exception{

    const message = "Could not find resource at ";
    const code = 500;

    public function __construct($url, ?Throwable $previous = null) {
        parent::__construct($this::message . $url, $this::code, $previous);
    }
}

?>