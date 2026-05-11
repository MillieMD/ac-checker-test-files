<?php

use AccessibilityChecker\LabelInserter;
use Dom\HTMLDocument;
use PHPUnit\Framework\TestCase;



final class LabelInserterTest extends TestCase
{

    const INPUT_FOLDER = __DIR__ . "/input/labelinserter-tests/";

    private LabelInserter $label_inserter;

    protected function setUp(): void
    {
        $this->label_inserter = new LabelInserter();
    }

    public function testInsertStyleBlock(){

        $dom = HTMLDocument::createFromFile(self::INPUT_FOLDER . "test-style-block.html");

        $this->label_inserter->insertStyleBlock($dom);

        $style_blocks = $dom->getElementsByTagName("style");

        $this->assertGreaterThanOrEqual(1, count($style_blocks));
    }

    public function testAppendStyle(){
        $dom = HTMLDocument::createFromFile(self::INPUT_FOLDER . "test-add-style.html");
        $node = $dom->getElementById("title");
        $xpath = $node->getNodePath();

        $this->label_inserter->insertLabel($dom, $xpath);

        $node = $dom->getElementById("title");

        $this->assertStringContainsString("accessibility-checker-fail", $node->className);
    }

}

?>
