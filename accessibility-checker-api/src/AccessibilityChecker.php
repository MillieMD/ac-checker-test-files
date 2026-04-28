<?php

namespace AccessibilityChecker;

use AccessibilityChecker\Validator\Validator;
use AccessibilityChecker\Validator\ValidatorResult;
use AccessibilityChecker\RuleSet;
use AccessibilityChecker\Issue;

use Dom;
use AccessibilityChecker\Exceptions\NullResourceException;
use AccessibilityChecker\Exceptions\InvalidIdentifierTypeException;
use AccessibilityChecker\LabelInserter;
use UnhandledMatchError;

class AccessibilityChecker {

    private $pages = [];

    const XML_REGEX = "/<\?xml/";

    public function __construct(
        protected Validator $validator, 
        protected Ruleset $ruleset,
        protected LabelInserter $label_inserter) {}

    public function validate($input){
        $this->ruleset->parseRules($input->rules);
        $urls = $this->getFinalUrls($input->url);

        foreach($urls as $url){

            $document = file_get_contents($url);

            // Cannot resolve URL. Do not return an error here as other URLs should still be checked
            if($document === false){
                continue;
            }

            $dom = \Dom\HTMLDocument::createFromString(file_get_contents($url), LIBXML_HTML_NOIMPLIED);

            $issues = $this->findIssues($dom);

            $this->label_inserter->insertStyleBlock($dom);

            foreach($issues as $issue){
                $this->label_inserter->insertLabel($dom, $issue->node, $issue->message);
            }

            $html = $dom->saveHTML();

            $this->pages[] = [
                "url" => $url,
                "issues" => $issues,
                "html" => $html
            ];

        }

        return $this->pages;

    }

    function getFinalUrls($url) : array{

        $urls = [$url];
        $document = file_get_contents($url); // First URL is always guaranteed to resolve if we get here

        // If input is XML, get list of URLs
        // Strict matching here used - see www.php.net/manual/function.preg-match.php for justification
        if(preg_match($this::XML_REGEX, $document) === 1){
            $xml = Dom\XMLDocument::createFromString($document);

            $url_elements = $xml->getElementsByTagName("loc");

            foreach($url_elements as $url_element){
                $urls[] = $url_element->textContent;
            }

            // Remove first element - in this case this is ALWAYS the sitemap.xml url
            array_splice($urls, 0, 1);

        }

        return $urls;
    } 

    function findIssues(\Dom\HTMLDocument $dom) : array{

        $issues_found = [];

        foreach($this->ruleset->getRules() as $rule){

            try{
                
                $nodes = match($rule["id"]->type){
                    IdentifierType::ELEMENT => $dom->getElementsByTagName($rule["id"]->value),
                    IdentifierType::DOT_CLASS => $dom->getElementsByClassName($rule["id"]->value),
                    IdentifierType::ID => [$dom->getElementById($rule["id"]->value)]
                };
            
            }catch (UnhandledMatchError $e){
                throw new InvalidIdentifierTypeException($rule["id"]->type);
            }

            foreach($nodes as $node){
                $result = call_user_func(
                    [$this->validator, $rule["relationship"]], 
                    $node, 
                    ...$rule["params"]);

                if($result == ValidatorResult::FAIL){
                    $issues_found[] = new Issue($node->getNodePath(), "FAILED: " . $rule["id"]->value . " " . $rule["relationship"] . " " . implode(" ", $rule["params"]));
                }

                if($result == ValidatorResult::ERROR){
                    $issues_found[] = new Issue($node->getNodePath(), "ERROR WHILE TESTING: " . $rule["id"]->value . " " . $rule["relationship"] . " " . implode(" ", $rule["params"]));
                }

            }

        }

        return $issues_found;
    }

}

?>