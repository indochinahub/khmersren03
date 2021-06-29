<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table      ;
    protected $primaryKey ;
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';

    public function __construct(){
        parent::__construct();

    }

    // return Object Or False
    public function find_by_id(int $id){

        if( $row = $this->find($id) ){
            return $row;

        }else{
            return false;
        }
    }


}


