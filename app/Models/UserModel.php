<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends BaseModel
{

    public function __construct(){
        parent::__construct();
        $this->table = "user";
        $this->primaryKey = $this->table."_id";
    }



}


