<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class MessageModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->message_model = new MessageModel();

    }    


    //return array of object with new property
    public function test_add_active_date_property_to_message(){

        $message1 = new \stdClass;
        $message1->message_senddate = "2021-04-22 21:50:22";
        $message1->message_readdate = NULL;
      
        $message2 = new \stdClass;
        $message2->message_senddate = "2021-04-22 21:50:22";
        $message2->message_readdate = "2021-04-23 21:50:22";

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
   
}
