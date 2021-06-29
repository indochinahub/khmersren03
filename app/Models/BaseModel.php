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
    public function get_by_id(int $id){

        if( $row = $this->find($id) ){
            return $row;

        }else{
            return false;
        }
    }

    // return Array Of Object Or Blank Array
    public function get_by_ids( array $ids){

        if( $ids === [] ){
            return [];
        }elseif( $rows = $this->find($ids) ){
            return $rows;
        }
    }

    // return AffectedRows
    public function delete_by_id(int $id){

        if( $this->get_by_id($id) === false) { 
            return 0;
        }else{
            $this->delete($id);
            return $this->affectedRows();
        }
    }

    public function delete_by_ids(array $ids){
        

    }


}


