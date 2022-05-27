<?php

namespace App\Library;

use CodeIgniter\Test\CIUnitTestCase;

class FooTest extends CIUnitTestCase
{
    public function testFooNotBar()
    {
        $this->assertEquals(1,1);
    }
}