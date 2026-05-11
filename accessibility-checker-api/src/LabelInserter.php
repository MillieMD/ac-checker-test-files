<?php

namespace AccessibilityChecker;

use Dom\HTMLDocument;
use Dom\XPath;

class LabelInserter {

    const FAIL_CLASS = "accessibility-checker-fail";
    const STYLE_BLOCK = ".accessibility-checker-fail{border: 2px solid red;}";

    public function insertStyleBlock(HTMLDocument $dom){
        $style_block = $dom->createElement("style");
        $style_block->textContent = $this::STYLE_BLOCK;

        $dom->body->appendChild($style_block);
    }

    public function insertLabel(HTMLDocument $dom, string $node_path){
        $xpath = new XPath($dom);
        $node = $xpath->query($node_path)[0];

        $node->className = $node->className . " " . $this::FAIL_CLASS;
    }

}

?>