<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class CardcommentModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->cardcomment_model = new CardcommentModel();

    }    

    // return One
    public function test_returnOne(){

        $this->cardcomment_model->returnOne();

        $result         =   [ 
                                0,
                            ];

        $expectedResult =   [ 
                                1
                            ];

        $this->assertSame($expectedResult, $result);   
    }
        
    
}