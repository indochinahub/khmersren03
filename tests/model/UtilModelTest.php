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
}