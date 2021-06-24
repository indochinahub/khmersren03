<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UtilModelTest extends CIUnitTestCase
{

    var $util_model;

    public function __construct(){
        parent::__construct();
        $this->util_model =
        
        
    }

    public function test_get_class_from_fullname()
    {
        $util_model = new UtilModel();
        $result1 = $util_model->get_class_from_fullname("\Apps\Test\MyClass");
        $result2 = $util_model->get_class_from_fullname("\Apps\Test\MyClass");
        
        $result             =   [ $result1, $result2 ];
        $expectedResult     =   [ "MyClass" ];

        $this->assertSame($result,$expectedResult);
        
    }
}