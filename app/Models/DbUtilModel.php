<?php

namespace App\Models;

class DbUtilModel extends MyModel
{
    // return array of table name
    public function get_arr_table_name(){

        $sql = " SHOW TABLES ";
        $query = $this->query($sql);

        if( $arr_result = $query->getResult() ){

            $arr_table_name = [];
            foreach( $arr_result as $result ){
                array_push( $arr_table_name, $result->Tables_in_wittayan_khmersren);
            }

            return $arr_table_name;
        }else{

            return [];
        }
    }
}



