<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\CardModel;

class PostModelTest extends CIUnitTestCase
{
    var $post_model;


    public function setUp(): void
    {
        parent::setUp();
        $this->post_model = new PostModel();
    }

    // return array_of_object
    public function test_get_by_postcategory_id(){

        $result1 = $this->post_model->get_by_postcategory_id($postcategory_id = 0);
        $result2 = $this->post_model->get_by_postcategory_id($postcategory_id = 12);

        $result         =   [   
                                $result1,
                                count($result2),
                            ];
        $expectedResult =   [ 
                                [],
                                2,
                            ];
        $this->assertSame($expectedResult, $result);
    }


    // return int
    public function test_get_num_by_postcategory_id(){

        $result1 = $this->post_model->get_num_by_postcategory_id($postcategory_id = 0);
        $result2 = $this->post_model->get_num_by_postcategory_id($postcategory_id = 12);

        $result         =   [   
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                0,
                                2,
                            ];
        $this->assertSame($expectedResult, $result);        

    }

    // return array of object
    public function test_get_by_user_id(){

        // I sure that the user_id is always valid
        $result2 = $this->post_model->get_by_user_id($user_id = 1);

        $result         =   [   
                                count($result2),
                            ];
        $expectedResult =   [ 
                                8,
                            ];   
        $this->assertSame($expectedResult, $result);                                 
    }  
    
}