<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class DeckModelTest extends CIUnitTestCase
{
    var $deck_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->deck_model = new DeckModel();
    }    

    // return Array Of Ojbect
    public function test_get_by_cardgroup_id(){

        $result1 = $this->deck_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result2 = $this->deck_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result             =   [ 
                                    count($result1),
                                    is_object($result1[0]),
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    2,
                                    true,
                                    [],
                                ];
        $this->assertSame($result,$expectedResult);    
        
    }

    //get_by_cardgroup_id($cardgroup_id){

    /*
    public function test_get_by_course_id(){
        $this->deck_model->get_by_course_id($course_id = 1);

        $result             =   [ 
                                    0
                                ];
        $expectedResult     =   [ 
                                    1
                                ];

        $this->assertSame($result,$expectedResult);        
    }
    */
    

    
    
}