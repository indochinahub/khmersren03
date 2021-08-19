<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class DbUtilModelTest extends CIUnitTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->dbutil_model = new DbUtilModel();

    }    

    // return array of table name
    public function test_get_arr_table_name(){

        $result1 = $this->dbutil_model->get_arr_table_name();

        $result         =   [ 
                                count($result1) > 0
                            ];
        $expectedResult =   [ 
                                true
                            ];

        $this->assertSame($expectedResult, $result);     
    }

}