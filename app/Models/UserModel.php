<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends MyModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "user";
        $this->primaryKey = $this->table."_id";
    }

    // return UserObject or False
    public function get_validated_user($username, $password){
        $username = $this->db->escape(trim($username));
        $password = $this->db->escape(trim($password));

        $where_clause = " WHERE user_username = ".$username." AND user_password = ".$password;
        if( $arr_row = $this->get_where( $where_clause ) ){
            return $arr_row[0];

        }else{
            return false;

        }

    }



}


