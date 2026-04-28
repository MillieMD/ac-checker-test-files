<?php

    namespace AccessibilityChecker;

    enum IdentifierType : string {
        case ELEMENT = "element";
        case DOT_CLASS = "class";
        case ID = "id";
    }

?>