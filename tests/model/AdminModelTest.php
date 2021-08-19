<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class AdminModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->admin_model = new AdminModel();

    }    

    // return array of table name
    public function test_get_arr_table_name(){

        $result1 = $this->admin_model->get_arr_table_name();

        $result         =   [ 
                                count($result1) > 0
                            ];
        $expectedResult =   [ 
                                true
                            ];

        $this->assertSame($expectedResult, $result);     
    }

}