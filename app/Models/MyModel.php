<?php

namespace App\Models;

use CodeIgniter\Model;

class MyModel extends Model
{
    protected $table      ;
    protected $primaryKey ;
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';

    public function __construct(){
        parent::__construct();
        $this->protect(false);

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
        $dbutil_name = new DbutilModel;
        return $dbutil_name->get_all_row_Of_table($this->table);
    }

    // Return Array Of column
    public function get_column(){
        $dbutil_name = new DbutilModel;

        return $dbutil_name->get_column_of_table($this->table);
    }

    // return Int
    public function get_num_row(){
        $dbutil_name = new DbutilModel;
        
        return $dbutil_name->get_num_all_row_of_table($this->table);
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
            return $this->db->affectedRows();
        }
    }

    // return AffectedRows
    public function delete_by_ids(array $ids){
        $util_model = new UtilModel();
        
        if($rows = $this->get_by_ids($ids)){
            $arr_id = $util_model->get_property_value_Of_many_objects_as_array($rows, $this->primaryKey);
            $this->delete($arr_id);
            return $this->db->affectedRows();
            
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

    // Return affected row
    public function update_by_id(int $id, $detail){
        
        if( $this->get_by_id($id) === false  ){
            return 0;

        }else{
            
            $this->update([$id], $detail);

            return $this->db->affectedRows();
        }
    }

    // return db object with null value
    public function get_object_with_null_value(){

        $arr_column = $this->get_column();

        $obj = new \stdClass;
        foreach( $arr_column as $column){
            $obj->$column = null;
        }

        return $obj;
    }

    // return primary key
    public function get_primary_key(){
        return $this->primaryKey ;
    }
}


