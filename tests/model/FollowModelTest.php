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

        $result1 = $this->follow_model->get_my_follower_id($my_id = 0);
        $result2 = $this->follow_model->get_my_follower_id($my_id = 1);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                [],
                                ["2","94"]
                            ];
        $this->assertSame($expectedResult, $result);
    }

    //return array of id
    public function test_get_id_of_whom_i_follow(){

        $result1 = $this->follow_model->get_id_of_whom_i_follow($my_id = 0);
        $result2 = $this->follow_model->get_id_of_whom_i_follow($my_id = 1);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                [],
                                ["2","94","60","29"],
                            ];
        $this->assertSame($expectedResult, $result);
    }

    //return relation text
    public function test_get_my_relation_with_other(){
        
        $result1 = $this->follow_model->get_my_relation_with_other($my_id = 1   ,$other_id = 2 );
        $result2 = $this->follow_model->get_my_relation_with_other($my_id = 1   ,$other_id = 60 );
        $result3 = $this->follow_model->get_my_relation_with_other($my_id = 29  ,$other_id = 1 );
        $result4 = $this->follow_model->get_my_relation_with_other($my_id = 0 ,$other_id = 1 );

        $result         =   [ 
                                $result1,
                                $result2,
                                $result3,
                                $result4,
                            ];
        $expectedResult =   [ 
                                "we_folow_each_other",
                                "i_folow_the_other",
                                "the_other_follow_me",
                                "we_have_no_relation"
                            ];
        $this->assertSame($expectedResult, $result);        
    }    

    // return InsertedId or false
    public function test_follow_the_other(){

        $result1 = $this->follow_model->follow_the_other($my_id = 1, $other_id = 2);
        $result2 = $this->follow_model->follow_the_other($my_id = 1, $other_id = 3);

        $result         =   [ 
                                $result1,
                                $result2 > 0,
                            ];
        $expectedResult =   [ 
                                false,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);
        
        $sql = " DELETE FROM follow WHERE follow_id = $result2 ";
        $this->follow_model->query($sql);
    }

    // return object or false
    public function test_get_follow_by_user_id(){

        $result1 = $this->follow_model->get_follow_by_user_id($my_id = 0, $other_id = 0);
        $result2 = $this->follow_model->get_follow_by_user_id($my_id = 1, $other_id = 2);

        $result         =   [ 
                                $result1,
                                is_object($result2),
                            ];
        $expectedResult =   [ 
                                false,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);
    }

    // return id
    public function test_get_id_of_whom_i_not_relate_to(){

        $result1 = $this->follow_model->get_id_of_whom_i_not_relate_to($my_id = 1, $num = 15);
        $result2 = $this->follow_model->get_id_of_whom_i_not_relate_to($my_id = 0, $num = 15);

        $result         =   [ 
                                count($result1),
                                count($result2),
                            ];
        $expectedResult =   [ 
                                15,
                                15,
                            ];
        $this->assertSame($expectedResult, $result);        
    }

    // return array of id
    public function test_get_id_of_whom_i_relate_to(){

        $result1 = $this->follow_model->get_id_of_whom_i_relate_to($my_id = 1);
        $result2 = $this->follow_model->get_id_of_whom_i_relate_to($my_id = 0);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                ["2","94","60","29"],
                                [],
                            ];
        $this->assertSame($expectedResult, $result);                
    }

}
