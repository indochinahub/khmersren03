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

    // return Array Of Object
    public function get_all_row(){
        return $this->findAll();
    }

    // Return Array Of Properties
    public function get_fields(){
        return $this->getFieldNames($this->table);

    }

    // return Int
    public function get_num_row(){
        $this->get_all_row();
        return $this->countAll();
    }
            
    // return Assoc array Or Blank Array
    public function get_all_rows_as_assoc(){
        $arr_row = $this->get_all_row();
        $util_model = new UtilModel();

        return $util_model->get_assoc_from_array_of_object(
                        $arr_object = $arr_row, 
                        $key_property = $this->table."_id"
                );

    }

    //return Array of Object
    public function get_where($where_clause){

        $sql = " SELECT * FROM ".$this->table ;
        if($where_clause === ""){
            $sql .= " WHERE 1 ";
        }else{
            $sql .= " $where_clause ";
        }
        $query = $this->query($sql);

        return $query->getResult();
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

    // return AffectedRows
    public function delete_by_ids(array $ids){
        $util_model = new UtilModel();
        
        if($rows = $this->get_by_ids($ids)){
            $arr_id = $util_model->get_property_value_Of_many_objects_as_array($rows, $this->primaryKey);
            $this->delete($arr_id);
            return $this->affectedRows();
            
        }else{
            return 0;
        }


    }

    // return AffectedRows
    public function delete_where($where_clause){

        $sql = " DELETE FROM ".$this->table;
        if($where_clause === ""){
            die(" Need where_clause! in BaseModel::delete_where() ");
        }else{
            $sql .= " $where_clause ";
        }

        $this->db->query($sql);
        
        return $this->db->affectedRows();     

    }







}


