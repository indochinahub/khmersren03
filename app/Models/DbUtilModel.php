<?php

namespace App\Models;

class DbutilModel extends MyModel
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

    // Return Array Of column
    public function get_column_of_table($table_name){
        return $this->getFieldNames($table_name);
    }

    // return array of row
    public function get_all_row_Of_table($table_name){

        $db = \Config\Database::connect();

        $sql = " SELECT * FROM $table_name WHERE 1 ";
        $query = $db->query($sql);

        return $query->getResult();
    }

    // return int
    public function get_num_all_row_of_table($table_name){

        $db = \Config\Database::connect();

        $primary_key = $table_name."_id";

        $sql = " SELECT COUNT($primary_key) AS num FROM $table_name WHERE 1 ";
        $query = $db->query($sql);

        $result = $query->getResult();   
        
        return $result[0]->num; 
    }

}



