<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table_name;

    public function __construct(){
        parent::__construct();
    }

    public function _delete($where_clause = ""){

        $sql = " DELETE FROM ".$this->get_table_name() ;
        if($where_clause === ""){
            die("Need where_clause!");
        }else{
            $sql .= " $where_clause ";
        }

        $this->query($sql);
        return $this->affectedRows();
    }

    public function get_table_name(){
        return $this->table_name;
    }
        

    

}


