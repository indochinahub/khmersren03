<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class DbutilModelTest extends CIUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->dbutil_model = new DbUtilModel();

    }

    // return array of table name
    public function test_get_arr_table_name()
    {
        $result1 = $this->dbutil_model->get_arr_table_name();

        $result = [
            count($result1) > 0
        ];
        $expectedResult = [
            true
        ];

        $this->assertSame($expectedResult, $result);
    }

    // Return Array Of column
    public function test_get_column_of_table()
    {
        $result1 = $this->dbutil_model->get_column_of_table("user");

        $result = [
            count($result1) > 0,
            $result1[0]
        ];
        $expectedResult = [
            true,
            "user_id"
        ];

        $this->assertSame($expectedResult, $result);

    }

    // return array of row
    public function test_get_all_row_Of_table()
    {
        $result1 = $this->dbutil_model->get_all_row_Of_table($table_name = "user");

        $result = [
            count($result1) > 0
        ];
        $expectedResult = [
            true
        ];

        $this->assertSame($expectedResult, $result);
    }

    // return int
    public function test_get_num_all_row_of_table()
    {
        $result1 = $this->dbutil_model->get_num_all_row_of_table(
            $table_name = "user"
        );

        $result = [
            $result1 > 0
        ];
        $expectedResult = [
            true
        ];
        $this->assertSame($expectedResult, $result);
    }
}
