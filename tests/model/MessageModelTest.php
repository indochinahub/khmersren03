<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class MessageModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->message_model = new MessageModel();

        $sql =  " UPDATE message SET message_readtime = null ";
        $sql .= " WHERE  message_id in (46,47) ";
        $this->message_model->query($sql);
        


    }    


    //return array of object with new property
    public function test_add_active_date_property_to_message(){

        $message1 = new \stdClass;
        $message1->message_sendtime = "2021-04-22 21:50:22";
        $message1->message_readtime = NULL;
      
        $message2 = new \stdClass;
        $message2->message_sendtime = "2021-04-22 21:50:22";
        $message2->message_readtime = "2021-04-23 21:50:22";

        $result1 = $this->message_model->add_active_date_property_to_message($arr_message = [$message1,$message2]);
        $result2 = $this->message_model->add_active_date_property_to_message($arr_message = []);

        $result         =   [ 
                                $result1[0]->active_date,
                                $result1[1]->active_date,

                                $result2,
                            ];
        $expectedResult =   [ 
                                "2021-04-22 21:50:22",
                                "2021-04-23 21:50:22",

                                [],
                            ];

        $this->assertSame($expectedResult, $result);
    }


    // return array of object
    public function test_get_other_id_wchich_chatted_with_user(){
        
        $result1 = $this->message_model->get_other_id_wchich_chatted_with_user($user_id = 1);
        $result2 = $this->message_model->get_other_id_wchich_chatted_with_user($user_id = 0);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                ["2","6","3"],
                                [],
                            ];

        $this->assertSame($expectedResult, $result);
    }

    // return object or false
    public function test_get_last_active_messge_with_other(){

        $result1 = $this->message_model->get_last_active_messge_with_other($user_id = 1,$other_id = 2);
        $result2 = $this->message_model->get_last_active_messge_with_other($user_id = 0,$other_id = 2);

        $result         =   [ 
                                $result1->message_id,

                                $result2
                            ];
        $expectedResult =   [ 
                                "28",

                                false,
                            ];
        $this->assertSame($expectedResult, $result);
    }

    // return array
    public function test_get_message_with_other(){

        $result1 = $this->message_model->get_message_with_other($user_id = 1,$other_id = 2);
        $result2 = $this->message_model->get_message_with_other($user_id = 0,$other_id = 0);

        $result         =   [ 
                                count($result1),
                                count($result2),
                            ];
        $expectedResult =   [ 
                                17,
                                0,
                            ];
        $this->assertSame($expectedResult, $result);        
    }

    // return  int
    public function test_get_num_unread_message(){

        $result1 = $this->message_model->get_num_unread_message($user_id = 0,$other_id = 0);
        $result2 = $this->message_model->get_num_unread_message($user_id = 1,$other_id = 2);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                0,
                                6,
                            ];
        $this->assertSame($expectedResult, $result);
    }
    
    // return int
    public function test_get_total_num_unread_message(){

        $result1 = $this->message_model->get_total_num_unread_message($user_id = 0);
        $result2 = $this->message_model->get_total_num_unread_message($user_id = 1);

        $result         =   [ 
                                $result1,
                                $result2,
                            ];
        $expectedResult =   [ 
                                0,
                                10,
                            ];
        $this->assertSame($expectedResult, $result);
    }

    // return num rows
    public function test_set_read_time(){

        $result1 = $this->message_model->set_read_time(
                                $user_id = 3,
                                $other_id = 1,
                                time());

        $result         =   [ 
                                $result1
                            ];
        $expectedResult =   [ 
                                2
                            ];
        $this->assertSame($expectedResult, $result);        
    }
   
}
