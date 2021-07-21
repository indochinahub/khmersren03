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
    public function test_get_by_course_id(){

        $result1 = $this->deck_model->get_by_course_id($course_id = 1);
        $result2 = $this->deck_model->get_by_course_id($course_id = 0);

        $result             =   [ 
                                    count($result1),
                                    $result1[0]->deck_name,
                                    $result2

                                ];
        $expectedResult     =   [ 
                                    5,
                                    "Practice 01",
                                    []
                                ];

        $this->assertSame($result,$expectedResult);
    }

    // return Int Or Zero
    public function test_get_average_interval(){
        
        $result1 = $this->deck_model->get_average_interval(
                                    $deck_id = 0,
                                    $user_id = 0
                                );
        $result2 = $this->deck_model->get_average_interval(
                                    $deck_id = 1,
                                    $user_id = 1
                                );

        $result             =   [ 
                                    $result1,
                                    $result2,
                                ];
        $expectedResult     =   [ 
                                    0,
                                    1,
                                ];

        $this->assertSame($result,$expectedResult);        
    }

    /*
        $result01 =  $this->practice_model->get_average_interval($deck_id = 1 ,$user_id = 1);
        $result02 =  $this->practice_model->get_average_interval($deck_id = 1 ,$user_id = 0);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   1,
                                0,

                            ];

    */
    
}