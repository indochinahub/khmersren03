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

    }    

    public function test_delete() {

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->user_model->query($sql);

        $where_clause = " WHERE user_id = 7 ";
        $result1 = $this->user_model->_delete($where_clause);

        $result         =   [ $result1 ];
        $expectedResult =   [ 1 ];

        $this->assertSame($expectedResult, $result);       
        
        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->user_model->query($sql);        

    }
    
}