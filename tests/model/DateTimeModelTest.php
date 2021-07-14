<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class DateTimeModelTest extends CIUnitTestCase
{
    var $datetime_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->datetime_model = new DateTimeModel();
    }

    public function test_test(){

        $result             =   [ 
                                    1
                                ];

        $expectedResult     =   [ 
                                    1
                                ];

        $this->assertSame($result,$expectedResult);   

    }
    

    
}