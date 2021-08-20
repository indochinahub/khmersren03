<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class FollowModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->follow_model = new FollowModel();
    }

    //return array of id
    public function test_get_my_follower_id(){

        $result1 = $this->follow_model->get_my_follower_id($user_id = 0);
        $result2 = $this->follow_model->get_my_follower_id($user_id = 1);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                [],
                                ["2","3","6","94"]
                            ];
        $this->assertSame($expectedResult, $result);
    }

    //return array of id
    public function test_user_id_of_whom_i_follow(){

        $result1 = $this->follow_model->user_id_of_whom_i_follow($user_id = 0);
        $result2 = $this->follow_model->user_id_of_whom_i_follow($user_id = 1);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                [],
                                ["2","3","6","94","60","29"],
                            ];
        $this->assertSame($expectedResult, $result);

    }
   
}