<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class MyModelTest extends CIUnitTestCase
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

    // return Array Of Object
    public function test_get_all_row(){

        $result01 = $this->user_model->get_all_row();

        $result =           [ 
                                count($result01) > 50,
                            ];
        $expectedResult =   [ 
                                true,
                            ];

        $this->assertSame($expectedResult, $result);              
    }

    // return Assoc array Or Blank
    public function test_get_all_rows_as_assoc(){

        $result1 = $this->user_model->get_all_rows_as_assoc();

        $result =           [ 
                                count($result1) > 0,
                                $result1["1"]->user_id, 
                            ];
        $expectedResult =   [ 
                                true,
                                "1",
                            ];
        $this->assertSame($expectedResult, $result);              

    }

    // Return Array Of column
    public function test_get_column(){
        $result1 = $this->user_model->get_column();
        $result =           [   
                                $result1[0],
                                $result1[1],
                                $result1[2],
                                $result1[3]
                            ];

        $expectedResult =   [ 
                                'user_id',
                                'user_display_name',
                                'user_username',
                                'user_password',
                            ];
        $this->assertSame($expectedResult, $result);    
    }

    // return Int
    public function test_get_num_row(){
        $result1 = $this->user_model->get_num_row();

        $result =           [   
                                $result1 > 0
                            ];

        $expectedResult =   [ 
                                true
                            ];
        $this->assertSame($expectedResult, $result);
    }

    //return Array of Object
    public function test_get_where(){    
        
        $where_clause = " WHERE user_username = 'user01' ";
        $result1 = $this->user_model->get_where($where_clause);

        $where_clause = " WHERE user_username = 'xxxx' ";
        $result2 = $this->user_model->get_where($where_clause);        

        $result         =   [   
                                count($result1),
                                $result2,
                            ];
        $expectedResult =   [
                                1,
                                [],
                            ];
        $this->assertSame($expectedResult, $result);
    }

    // return AffectedRow
    public function test_delete_where(){

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->user_model->query($sql);
        
        $where_clause = " WHERE user_id = 7 ";
        $result1 = $this->user_model->delete_where($where_clause);


        $where_clause = " WHERE user_id = 0 ";
        $result2 = $this->user_model->delete_where($where_clause);

        $result         =   [   
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [
                                1,
                                0,
                            ];
        $this->assertSame($expectedResult, $result);
                
        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);          

    }

    // Return affected row
    public function test_update_by_id(){

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->user_model->query($sql);

        $result1 = $this->user_model->update_by_id($id = 7, $detail = [ "user_username"=>"xxxxx"]);    
        $result2 = $this->user_model->update_by_id($id = 0, $detail = [ "user_username"=>"xxxxx"]);    
        
        $result         =   [   
                                $result1,
                                $result2,
                            ];

        $expectedResult =   [
                                1,
                                0,
                            ];
        $this->assertSame($expectedResult, $result);
               
        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);          

    }

    // return db object with null value
    public function test_get_object_with_null_value(){

        $result1 = $this->user_model->get_object_with_null_value();

        $result         =   [   
                                is_object($result1),
                                $result1->user_id,
                            ];
        $expectedResult =   [
                                true,
                                null
                            ];
        $this->assertSame($expectedResult, $result);
    }    

    // return primary key
    public function test_get_primary_key(){

        $result1 = $this->user_model->get_primary_key();

        $result         =   [   
                                $result1, 
                            ];
        $expectedResult =   [
                                "user_id",
                            ];
        $this->assertSame($expectedResult, $result);        
    }

        

        
        
    

}