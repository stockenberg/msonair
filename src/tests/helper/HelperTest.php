<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 11.10.2016
 * Time: 01:30
 */

namespace tests\helper;


use PHPUnit\Framework\TestCase;
use src\helpers\Helper;


class HelperTest extends TestCase
{

    public function testTranslateGender(){

        $this->assertEquals("Frau",  Helper::translateGender("female"));
        $this->assertEquals("Herr",  Helper::translateGender("male"));

    }

    public function testGetAlphabet(){
        $this->assertEquals(29, count(Helper::getAlphabet()));
    }

    public function testTranslateIntrestedIn(){
        $this->assertEquals("Trompete", Helper::translateIntresedIn("trumpet"));
        $this->assertEquals("Saxophon", Helper::translateIntresedIn("sax"));
        $this->assertEquals("Gitarre", Helper::translateIntresedIn("guitar"));
        $this->assertEquals("Klavier", Helper::translateIntresedIn("piano"));
        $this->assertEquals("Gesang", Helper::translateIntresedIn("voice"));
    }

}

