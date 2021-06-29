<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class BaseModelTest extends CIUnitTestCase
{
    var $user_model;

    public function setUp(): void
    {
        parent::setUp();
        $this->user_model = new UserModel();

        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);        

        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 8 ";
        $this->user_model->query($sql);        
    }    

    // return Object or FALSE
    public function test_get_by_id(){
        
        $result1 = $this->user_model->get_by_id($id = 0);
        $result2 = $this->user_model->get_by_id($id = 1);

        $result         =   [ 
                                $result1,
                                $result2->user_display_name 
                            ];
        $expectedResult =   [ 
                                false,
                                "Surasak" 
                            ];

        $this->assertSame($expectedResult, $result);               

    }    
    
    // return Array ofj Objects or Blank Array
    public function test_get_by_ids(){

        $result1 = $this->user_model->get_by_ids($ids = []);
        $result2 = $this->user_model->get_by_ids($ids = [1,2]);
        $result3 = $this->user_model->get_by_ids($ids = [0,1,2]);

        $result         =   [ 
                                count($result1),
                                count($result2),
                                count($result3)
                            ];

        $expectedResult =   [ 
                                0,
                                2,
                                2
                            ];

        $this->assertSame($expectedResult, $result);                       

    }

    // return AffectedRows
    public function test_delete_by_id(){

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->user_model->query($sql);

        $result1 = $this->user_model->delete_by_id($id = 0);
        $result2 = $this->user_model->delete_by_id($id = 7);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];

        $expectedResult =   [ 
                                0,
                                1,
                            ];

        $this->assertSame($expectedResult, $result);                               

        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);          

    }


    // return AffectedRows
    public function test_delete_by_ids(){

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->user_model->query($sql);
        $sql = " INSERT INTO user(user_id, user_username) VALUES (8, 'test_user2') ";
        $this->user_model->query($sql);       

        $result1 = $this->user_model->delete_by_ids($ids = []);
        $result2 = $this->user_model->delete_by_ids($ids = [0,7,8]);
        $result3 = $this->user_model->delete_by_ids($ids = [0]);

        $result =           [ 
                                $result1,
                                $result2,
                                $result3,
                            ];

        $expectedResult =   [ 
                                0,
                                2,
                                0,
                            ];

        $this->assertSame($expectedResult, $result);              

        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);
        $sql = " DELETE FROM user WHERE user_id = 8 ";
        $this->user_model->query($sql);          


        
    }

}