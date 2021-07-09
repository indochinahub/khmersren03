<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UserModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->user_model = new UserModel();

    }    

    // return UserObject Or False
    public function test_get_validated_user(){

        $result1 = $this->user_model->get_validated_user(
                                $username = "user01" ,
                                $password = "1234"
                            );

        $result2 = $this->user_model->get_validated_user(
                                $username = "" ,
                                $password = ""
                            );

        $result         =   [ 
                                is_object($result1),
                                $result2,

                            ];
        $expectedResult =   [ 
                                true,
                                false,
                            ];

        $this->assertSame($expectedResult, $result);                               

    }

    //return Object or false
    public function test_get_user_by_id(){
        
        $result1 = $this->user_model->get_user_by_id($user_id = 1);
        $result2 = $this->user_model->get_user_by_id($user_id = 2);
        $result3 = $this->user_model->get_user_by_id($user_id = 0);

        $result         =   [ 
                                $result1->user_id,
                                $result1->displayname,
                                $result2->displayname,
                                $result3,

                            ];

        $expectedResult =   [ 
                                "1",
                                "Surasak",
                                "user02",
                                false,
                            ];

        $this->assertSame($expectedResult, $result);                               
    }
    
    
}