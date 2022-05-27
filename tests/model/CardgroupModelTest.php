<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class CardgroupModelTest extends CIUnitTestCase
{
    var $cardgroup_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->cardgroup_model = new CardgroupModel;
    }

    // return array Of object Or blank array
    public function test_get_by_course_id(){

        $result1 = $this->cardgroup_model->get_by_course_id($course_id = 1);
        $result2 = $this->cardgroup_model->get_by_course_id($course_id = 0);

        $result             =   [ 
                                    count($result1),
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    3,
                                    [],
                                ];
        $this->assertSame($result,$expectedResult);        

    }
    

    
}