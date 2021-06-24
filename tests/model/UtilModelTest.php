<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UtilModelTest extends CIUnitTestCase
{

    public function __construct(){
        parent::__construct();
        
    }

    public function test_get_class_from_fullname()
    {
        $util_model = new UtilModel();
        $result = $util_model->get_class_from_fullname("\Apps\Test\MyClass");
        
        echo "*******************\n";
        echo " test test test \n";
        echo "*******************\n";
        
        $result             =   [ $result ];
        $expectedResult     =   [ "MyClass" ];

        $this->assertSame($result,$expectedResult);
        
    }
}