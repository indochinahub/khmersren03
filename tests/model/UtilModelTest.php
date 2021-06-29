<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UtilModelTest extends CIUnitTestCase
{

    var $util_model;

    public function __construct(){
        parent::__construct();
        $this->util_model = new UtilModel();
        
        
    }

    public function test_get_class_from_fullname()
    {
        $result1 = $this->util_model->get_class_from_fullname("\Apps\Test\MyClass");
        $result2 = $this->util_model->get_class_from_fullname("Apps\Test\MyClass");
        
        $result             =   [ $result1, $result2 ];
        $expectedResult     =   [ "MyClass", "MyClass" ];

        $this->assertSame($result,$expectedResult);
        
    }

    public function test_get_assoc_from_array_of_object(){

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        $result01 =  $this->util_model->get_assoc_from_array_of_object(
                        $arr_object = $arr_student, 
                        $key_property = "id"
                    );

        $result         =   [   count($result01),
                                is_object($result01["1"]),
                                $result01["1"]->name,
                            ];

        $expectedResult =   [   3,
                                TRUE,
                                "Wittaya",
                            ];                                

        $this->assertSame($result,$expectedResult);
    }

    public function test_get_object_from_arr_object_with_pointer_by_key_id(){


        /*


                        
        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04->previous_id, //id = 1
                                $result04->next_id,
                                $result05->previous_id, //id = 2
                                $result05->next_id,
                                $result06->previous_id, //id = 3
                                $result06->next_id,                                                                
                            ];

        $expectedResult =   [   FALSE,
                                FALSE,
                                FALSE,
                                FALSE,  //id = 1
                                2,
                                1,  //id = 2
                                3,
                                2,  //id = 3
                                FALSE,                                                                
                            ];                        
        */

        $student1 = new \stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new \stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new \stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        // Return false
        $result01 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = [], 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result02 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "", 
                            $key_id = "1"
                        );
        $result03 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = ""
                        );                        
        $result04 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result05 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "2"
                        );                        
        $result06 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "3"
                        );                             

        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04->previous_id, //id = 1
                                $result04->next_id,
                                $result05->previous_id, //id = 2
                                $result05->next_id,
                                $result06->previous_id, //id = 3
                                $result06->next_id,
                            ];

        $expectedResult =   [   FALSE,
                                FALSE,
                                FALSE,
                                FALSE,  //id = 1
                                2,
                                1,  //id = 2
                                3,
                                2,  //id = 3
                                FALSE,                                                                
                            ];                                

        $this->assertSame($result,$expectedResult);                        

    }
}