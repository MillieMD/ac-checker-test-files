<?php

namespace AccessibilityChecker;

class Issue {
    public $node;
    public string $message;

    public function __construct($node, $message) {
        $this->node = $node;
        $this->message = $message;
    }

    public function __toString(){
        return $this->message;
    }
}

?>