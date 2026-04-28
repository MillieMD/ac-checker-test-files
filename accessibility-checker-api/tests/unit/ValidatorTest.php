<?php

use PHPUnit\Framework\TestCase;
use AccessibilityChecker\Validator\Validator;
use AccessibilityChecker\Validator\ValidatorResult;

final class ValidatorTest extends TestCase
{

    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testHasChildElementPass(): void
    {
        $html = "
            <html id='html-root'>
                <body>
                    body text
                </body>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "element", $identifier = "body");
        $this->assertSame(ValidatorResult::PASS, $result);
    }

    public function testHasChildElementFail()
    {
        $html = "
            <html id='html-root'>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "element", $identifier = "body");
        $this->assertSame(ValidatorResult::FAIL, $result);
    }

    public function testHasChildClassPass()
    {
        $html = "
            <html id='html-root'>
                <body class='body-class'>
                    body text
                </body>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "class", $identifier = "body-class");
        $this->assertSame(ValidatorResult::PASS, $result);
    }

    public function testHasChildClassFail()
    {
        $html = "
            <html id='html-root'>
                <body>
                    body text
                </body>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "class", $identifier = "body-class");
        $this->assertSame(ValidatorResult::FAIL, $result);
    }

    public function testHasChildIdPass()
    {
        $html = "
            <html id='html-root'>
                <body id='body'>
                    body text
                </body>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "id", $identifier = "body");
        $this->assertSame(ValidatorResult::PASS, $result);
    }

    public function testHasChildIdFail()
    {
        $html = "
            <html id='html-root'>
                <body>
                    body text
                </body>
            </html>
        ";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("html-root");

        $result = $this->validator->hasChild($node, $identifier_type = "id", $identifier = "body");
        $this->assertSame(ValidatorResult::FAIL, $result);
    }

    public function testHasAttributePresent()
    {
        $html = "<img id='img' alt='lorem ipsum'>";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("img");

        $result = $this->validator->hasAttribute($node, "alt");
        $this->assertSame(ValidatorResult::PASS, $result);
    }

    public function testHasAttributeMissing()
    {
        $html = "<img id='img'>";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("img");

        $result = $this->validator->hasAttribute($node, "alt");
        $this->assertSame(ValidatorResult::FAIL, $result);
    }

    public function testHasAttributeWithValuePresent()
    {
        $html = "<img id='img' alt='loreum ipsum'>";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("img");

        $result = $this->validator->hasAttribute($node, "alt", $value = "loreum ipsum");
        $this->assertSame(ValidatorResult::PASS, $result);
    }

    public function testHasAttributeWithValueIncorrect()
    {
        $html = "<img id='img' alt='something else'>";

        $dom = \Dom\HTMLDocument::createFromString($html, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR);
        $node = $dom->getElementById("img");

        $result = $this->validator->hasAttribute($node, "alt", $value = "loreum ipsum");
        $this->assertSame(ValidatorResult::FAIL, $result);
    }
}
