<?php

namespace AccessibilityChecker\Validator;

use AccessibilityChecker\IdentifierType;
use Dom\Element;
use Dom\HTMLElement;

class Validator
{

    function hasAttribute(HTMLElement $node, string $attribute, $value = null): ValidatorResult
    {

        if ($node->attributes->getNamedItem($attribute) != null) {

            if ($value == null) {
                return ValidatorResult::PASS;
            }

            if ($node->attributes->getNamedItem($attribute)->textContent == $value) {
                return ValidatorResult::PASS;
            }
        }

        return ValidatorResult::FAIL;
    }

    function hasChild(HTMLElement $node, string $identifier_type, string $identifier): ValidatorResult
    {

        $id_type = IdentifierType::tryFrom($identifier_type);

        if ($id_type == null) {
            return ValidatorResult::ERROR;
        }

        foreach ($node->childNodes as $child) {

            // Following attributes can only be checked on HTMLElement Nodes 
            // which corresponds to nodeType 1
            if ($child->nodeType != 1) {
                continue;
            }

            switch ($id_type) {
                case IdentifierType::ELEMENT:
                    if (strtolower($child->tagName) == $identifier) {
                        return ValidatorResult::PASS;
                    }
                    break;

                case IdentifierType::DOT_CLASS:

                    if (str_contains($child->className, $identifier)) {
                        return ValidatorResult::PASS;
                    }
                    break;

                case IdentifierType::ID:
                    if (strtolower($child->id) == $identifier) {
                        return ValidatorResult::PASS;
                    }

                    break;
            }
        }

        return ValidatorResult::FAIL;
    }

    function hasParent(HTMLElement $node, string $identifier_type, string $identifier): ValidatorResult
    {

        $id_type = IdentifierType::tryFrom($identifier_type);

        if ($id_type == null) {
            return ValidatorResult::ERROR;
        }

        $parent = $node->parentElement;

        switch ($id_type) {
            case IdentifierType::ELEMENT:
                if (strtolower($parent->tagName) == $identifier) {
                    return ValidatorResult::PASS;
                }
                break;

            case IdentifierType::DOT_CLASS:

                if (str_contains($parent->className, $identifier)) {
                    return ValidatorResult::PASS;
                }
                break;

            case IdentifierType::ID:
                if (strtolower($parent->id) == $identifier) {
                    return ValidatorResult::PASS;
                }

                break;

            default:
                return ValidatorResult::ERROR;
        }

        return ValidatorResult::FAIL;
    }
}
