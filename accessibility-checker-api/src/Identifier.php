<?php

    namespace AccessibilityChecker;

    use AccessibilityChecker\IdentifierType;

    class Identifier{
        public IdentifierType $type;
        public string $value;

        public function __construct(IdentifierType $type, string $value) {
            $this->type = $type;
            $this->value = $value;
        }
    }

?>