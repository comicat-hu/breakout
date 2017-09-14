<?php 

use PHPUnit\Framework\TestCase;

require_once '../php/lib.php';

class InputTest extends TestCase
{
    public function testNormal()
    {
        $this->assertEquals('a', convertInput('a'));
        $this->assertEquals('abc', convertInput('abc'));
        $this->assertEquals('aaa', convertInput('aaa'));
        $this->assertEquals('0', convertInput('0'));
    }

    public function testSpace()
    {
        $this->assertEquals('', convertInput(' '));
        $this->assertEquals('', convertInput('   '));
        $this->assertEquals('', convertInput("\0"));
    }

    public function testHTML()
    {
        $this->assertEquals('&lt;script&gt;alert(&quot;xxx&quot;);&lt;/script&gt;', convertInput('<script>alert("xxx");</script>'));
        $this->assertEquals('&lt;br&gt;', convertInput('<br>'));
    }
}