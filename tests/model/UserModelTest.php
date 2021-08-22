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

    //return URL 
    public function test_get_avarta_url(){

        $result1 = $this->user_model->get_avarta_url($user_id = 6);
        $result2 = $this->user_model->get_avarta_url($user_id = 0);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];

        $expectedResult =   [ 
                                "http://127.0.0.1/khmersren03/asset/avatar/000061.jpg",
                                "http://127.0.0.1/khmersren03/asset/avatar/anonymous.jpg"
                            ];

        $this->assertSame($expectedResult, $result);
    }

    // return affected rows
    public function test_update_visit_time(){

        $result1 = $this->user_model->update_visit_time($user_id = 1);

        $result         =   [ 
                                $result1
                            ];

        $expectedResult =   [ 
                                1
                            ];

        $this->assertSame($expectedResult, $result);        
    }

    // return text
    public function test_get_user_displayname(){
        $user = new \stdClass;
        $user->user_display_name = "Displayname";
        $user->user_username = "Username" ;

        $result1 = $this->user_model->get_user_displayname($obj_user = $user );

        $user->user_display_name = "";
        $user->user_username = "Username" ;

        $result2 = $this->user_model->get_user_displayname($obj_user = $user );

        $result         =   [ 
                                $result1,
                                $result2,
                            ];

        $expectedResult =   [ 
                                "Displayname",
                                "Username"
                            ];

        $this->assertSame($expectedResult, $result);        

    }
    
    // return object or false
    public function test_get_by_post_id(){

        $result1 = $this->user_model->get_by_post_id($post_id = 0);
        $result2 = $this->user_model->get_by_post_id($post_id = 26);

        $result         =   [ 
                                $result1,
                                $result2->user_username,
                            ];

        $expectedResult =   [ 
                                false,
                                "admin"
                            ];

        $this->assertSame($expectedResult, $result);        
    }

    // return array_of_object
    public function test_get_last_visit_user_of_deck(){

        $result1 = $this->user_model->get_last_visit_user_of_deck(
                                $deck_id = 0, 
                                $num = 3    
                            );

        $result2 = $this->user_model->get_last_visit_user_of_deck(
                                $deck_id = 16, 
                                $num = 4    
                            );
                    
        $result         =   [ 
                                $result1,
                                count($result2) > 0
                            ];
        $expectedResult =   [ 
                                [],
                                true
                            ];
        $this->assertSame($expectedResult, $result);        
    }

    // return array_of_object
    public function test_get_last_visit_user_of_decks(){

        $result1 = $this->user_model->get_last_visit_user_of_decks(
                                            $arr_deck_id = [], 
                                            $num = 3    
                                        );        
        $result2 = $this->user_model->get_last_visit_user_of_decks(
                                            $arr_deck_id = [0], 
                                            $num = 3    
                                        );
        $result3 = $this->user_model->get_last_visit_user_of_decks(
                                            $arr_deck_id = [16], 
                                            $num = 4    
                                        );
        $result4 = $this->user_model->get_last_visit_user_of_decks(
                                            $arr_deck_id = [5,16], 
                                            $num = 4    
                                        ); 
        $result         =   [ 
                                $result1,
                                $result2,
                                count($result3) > 0,
                                count($result4) > 0,
                            ];
        $expectedResult =   [
                                [], 
                                [],
                                true,
                                true,
                            ];
        $this->assertSame($expectedResult, $result);        


    }    

    
}