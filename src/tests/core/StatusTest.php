<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 11.10.2016
 * Time: 02:08
 */

namespace tests\core;


use PHPUnit\Framework\TestCase;
use src\core\Status;

class StatusTest extends TestCase
{

    public function testStatus()
    {
        new Status("error", "myValue");
        $this->assertArrayHasKey("error", Status::read());
    }

}