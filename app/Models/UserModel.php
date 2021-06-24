<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    var $db;

    public function __construct(){
        parent::__construct();
        //$this->db = \Config\Database::connect();

    }

    public function get_num_user(){

        
        $query = $this->db->query(" SELECT * FROM user WHERE 1");

        return count($query->getResult());

    }

}


