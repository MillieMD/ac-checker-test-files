<?php
    
    namespace AccessibilityChecker;

use AccessibilityChecker\Exceptions\InvalidIdentifierTypeException;
use AccessibilityChecker\IdentifierType;
    use AccessibilityChecker\Identifier;

    class RuleSet{

        private $rules = [];

        function parseRules($rules_json){

            foreach($rules_json as $rule){
                $id_type = IdentifierType::tryFrom($rule->identifier->id_type);

                // Invalid ID type given
                if($id_type == null){
                    //  Invalid ID type -> rule doesnt get added
                    continue;
                }

                $id = new Identifier($id_type, $rule->identifier->value);
                $this->addRule($id, $rule->relationship, $rule->parameters);
            }
        }

        function addRule(Identifier $id, $relationship, $params){
            $this->rules[] = ["id" => $id, "relationship" => $relationship, "params" => (array) $params];
        }

        function getRules(){
            return $this->rules;
        }

    }
?>