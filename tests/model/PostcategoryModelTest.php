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


        $sql = "DELETE FROM postcategory WHERE id_user = 2 ";
        $this->postcategory_model->query($sql);

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

        // I am sure that $user_id  is always valid
        // So I didn't need to test with $user_id = 0
        $result1 = $this->postcategory_model->get_by_user_id($user_id = 1);

        // There is no default category for id_user : 2
        $sql = "DELETE FROM postcategory WHERE id_user = 2 ";
        $this->postcategory_model->query($sql);

        $result2 = $this->postcategory_model->get_by_user_id($user_id = 2);        

        $sql = "DELETE FROM postcategory WHERE id_user = 2 ";
        $this->postcategory_model->query($sql);

        $result         =   [   
                                count($result1),
                                count($result2),
                            ];
        $expectedResult =   [ 
                                5,
                                1,
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
                                [],
                                4,
                            ];
        $this->assertSame($expectedResult, $result);
    }

    //return insertedID  or false
    public function test_insert_default_postcategory(){

        $sql = "DELETE FROM postcategory WHERE id_user = 2 ";
        $this->postcategory_model->query($sql);

        $result1 = $this->postcategory_model->insert_default_postcategory($user_id = 1);
        $result2 = $this->postcategory_model->insert_default_postcategory($user_id = 2);
        
        $result         =   [   
                                $result1,
                                $result2 > 0,
                            ];
        $expectedResult =   [ 
                                false,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);        

        $sql = "DELETE FROM postcategory WHERE postcategory_id = $result2 ";
        $this->postcategory_model->query($sql);        
    }    


    


}