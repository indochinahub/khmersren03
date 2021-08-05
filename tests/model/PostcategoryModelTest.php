<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;


class PostcategoryModelTest extends CIUnitTestCase
{
    var $postcategory_model;


    public function setUp(): void
    {
        parent::setUp();
        $this->postcategory_model = new PostcategoryModel();
    }

    // return object or false
    public function test_get_by_post_id(){

        $result1 = $this->postcategory_model->get_by_post_id( $post_id = 0 );
        $result2 = $this->postcategory_model->get_by_post_id( $post_id = 26 );
        
        $result         =   [   
                                $result1,
                                $result2->postcategory_title,
                            ];

        $expectedResult =   [ 
                                false,
                                "ทั่วไป",
                            ];

        $this->assertSame($expectedResult, $result);                
    }

    // return array of object
    public function test_get_by_user_id(){

        $result1 = $this->postcategory_model->get_by_user_id($user_id = 0);
        $result2 = $this->postcategory_model->get_by_user_id($user_id = 1);

        $result         =   [   
                                $result1,
                                count($result2),
                            ];

        $expectedResult =   [ 
                                [],
                                5,
                            ];

        $this->assertSame($expectedResult, $result);
    }

    // return object or false
    public function test_get_default_postcategory(){

        $result1 = $this->postcategory_model->get_default_postcategory($user_id = 0);
        $result2 = $this->postcategory_model->get_default_postcategory($user_id = 1);
        
        $result         =   [   
                                $result1,
                                is_object( $result2 ),
                            ];

        $expectedResult =   [ 
                                false,
                                true,
                            ];

        $this->assertSame($expectedResult, $result);
    }    

    //return array of object
    public function test_get_user_postcategory(){

        $result1 = $this->postcategory_model->get_user_postcategory($user_id = 0);
        $result2 = $this->postcategory_model->get_user_postcategory($user_id = 1);
        
        $result         =   [   
                                $result1,
                                count($result2),
                            ];
        $expectedResult =   [ 
                                false,
                                4,
                            ];
        $this->assertSame($expectedResult, $result);

    }
    


}