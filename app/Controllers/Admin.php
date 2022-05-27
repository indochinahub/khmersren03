<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\StatisticModel;
use App\Models\DatetimeModel;
use App\Models\CardgroupModel;
use App\Models\FileModel;
use App\Models\DbutilModel;

class Admin extends MyController
{

    public function dashboard(){

        $data["page_title"] = 	"แดชบอร์ดผู้ดูแล";
        $data["page_link"] 	= 	[	"หน้าแรก",
                                    base_url()
                                ];		
        $this->_view("dashboard",$data);        
    }

    public function manageCardgroup(){

        $cardgroup_model = new CardgroupModel;  
        $course_model    = new CourseModel;
        $deck_model      = new DeckModel;
        $util_model     = new UtilModel;
        $card_model     = new CardModel;
        
        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        } 

        $assoc_course   = $course_model->get_all_rows_as_assoc();
        $arr_deck       = $deck_model->get_all_row();
        $arr_cardgroup  = $cardgroup_model->get_all_row();

        $data["arr_cardgroup"] = [];
        foreach( $arr_cardgroup as $cardgroup){

            $cardgroup->course = $assoc_course[$cardgroup->id_course];

            $arr_deck_of_cardgroup       =   $util_model->get_object_from_arr_object_that_match_property_condition(
                                                    $arr_deck, 
                                                    "id_cardgroup", 
                                                    $cardgroup->cardgroup_id, 
                                                    $operator = "=="
            
                                                );
            $txt_deck = "";
            foreach( $arr_deck_of_cardgroup as $deck ){
                $txt_deck = $txt_deck.$cardgroup->course->course_code."-".$deck->deck_name.",";
            }

            $txt_deck = substr($txt_deck, 0, -1);
            $cardgroup->txt_deck = $txt_deck;

            $cardgroup->num_card = $card_model->get_num_by_cardgroup_id($cardgroup->cardgroup_id);
            ////$cardgroup->num_card = 55;

            array_push( $data["arr_cardgroup"], $cardgroup );

        }

        $data["page_title"] = 	"จัดการกลุ่มบัตรคำ"; 
        $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                    base_url(["Admin", "dashboard"])
                               ];	        
        $this->_view("manageCardgroup",$data);                
    }

    public function exportCardgroup($table_name,$cardgroup_id,$confirm = "0"){

        $cardgroup_model= new CardgroupModel;
        $card_model     = new CardModel;
        $util_model    = new UtilModel;
        $file_model     = new FileModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        // Get Some Data
        $cardgroup  = $cardgroup_model->get_by_id( $cardgroup_id );

        $arr_card   = $card_model->get_by_cardgroup_id($cardgroup_id);
        $arr_card   = $util_model->sort_array_of_object_by_the_property( 
                                $arr_card, 
                                "card_id", 
                                $order_by ="asc"
                            );
        $num_card   = count($card_model->get_by_cardgroup_id($cardgroup_id));
        $arr_column = $card_model->get_column();

        if( $confirm === "0" ){

            $data    =  [   "page_title"=>"ยืนยันการส่งออกชุดบัตรคำ",
                            "what_happened"=>"ท่านกำลังส่งออกชุดบัตรคำหมายเลข $cardgroup_id จำนวน $num_card ข้อ ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","exportCardgroup",$table_name,$cardgroup_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Admin","manageCardgroup"]),
                        ];  		

            $this->_view("confirm",$data);    

        }else{

            // Get Line of Column
            $line_column    = $util_model->get_line_of_text_from_array (
                                        $arr_column, 
                                        "\t" 
                                    );
            $txt_data = $util_model->get_text_data_from_array_of_object(
                                $arr_card,$arr_column);
            $txt_to_write = $table_name."\n".$line_column."\n".$txt_data;

            // Write to file
            $file_model->create_file( ASSETPATH."01get_text_file_from_cardgroup/export_".$table_name.".txt");
            $file_model->write_to_file( ASSETPATH."01get_text_file_from_cardgroup/export_".$table_name.".txt", 
                                        $txt_to_write);

            $what_happened =  "ท่านกำลังส่งออกชุดบัตรคำหมายเลข $cardgroup_id จำนวน $num_card ข้อ <br>";
            $what_happened .= "ตาวโหลดได้ที่ ".ASSETPATH."01get_text_file_from_cardgroup/export_".$table_name.".txt";
            $data	=  [    "page_title"=>"บัตรคำได้ส่งออกเรียบร้อยแล้ว",
                            "what_happened"=>$what_happened,
                            "what_todo" => "กรุณาดาวน์โหลดเพื่อนำไปใช้งานต่อไป",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Admin", "manageCardgroup"])
                        ];
            $this->_warn($data);
        }

    }

    public function importTable($confirm = "0" ){

        $file_model = new FileModel;
        $card_model = new CardModel;
        $util_model = new UtilModel;
    
        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $full_pathname = ASSETPATH."02import_text_file_to_card/import.txt";
        $result = $file_model->get_data_from_export_file($full_pathname);
        $arr_column = $result->arr_column;
        $table_name = $result->table_name;  
        $arr_row = $result->arr_row;        

        if( $confirm === "0" ){

            $what_happened = "ท่านกำลังนำเข้าชุดบัตรคำจำนวน จำนวน ".count($arr_row)." ข้อ ดังรายละเอียดต่อไปนี้ <br>";

            $data = [];
            foreach( $arr_column as $column ){
                $what_happened .= "$column :: ". $arr_row[0]->$column."<br>";
            }

            $data    =  [   "page_title"=>"ยืนยันการนำเข้าชุดบัตรคำ",
                            "what_happened"=>$what_happened,
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","importTable", 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Admin","manageTable"]),
                        ];  		

            $this->_view("confirm",$data);

        }elseif( $confirm === "1" ){

            foreach( $arr_row as $row ){
                $data = [];
                foreach( $arr_column as $column ){
                    if( $row->$column === "NULL"  ){ 
                        $data[$column] = null;
                    }else{
                        $data[$column] = $util_model->sanitize_text_to_import(trim($row->$column))  ;
                    }
                }

                $table_model = $util_model->get_object_model_from_table_name($table_name);

                $table_model->update_by_id(
                                    $id = $data[ $table_model->get_primary_key() ], 
                                    $data
                                );
            }

            $what_happened = "ได้มีการนำเข้าบัตรคำเรียบร้อยแล้ว จำนวน ".count($arr_row)." ข้อ";
            $data	=  [    "page_title"=>"บัตรคำได้นำเข้าเรียบร้อยแล้ว",
                            "what_happened"=>$what_happened,
                            "what_todo" => "",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Admin", "manageCardgroup"])
                        ];
            $this->_warn($data);            
        }
    }

    public function manageTable(){

        $dbutil_model = new DbutilModel;
        $util_model = new UtilModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }
        
        $arr_table = $dbutil_model->get_arr_table_name();

        $data["arr_table"] = [];
        foreach( $arr_table as $table ){
            $obj = new \stdClass;
            $obj->name = $table;

            $obj->num_row = $dbutil_model->get_num_all_row_of_table($table); 

            array_push($data["arr_table"],$obj);
        }

        $data["arr_table"] = $util_model->sort_array_of_object_by_the_property( 
                                    $data["arr_table"], 
                                    "num_row", 
                                    $order_by ="desc"
                                );

        $data["page_title"] = 	"จัดการตาราง"; 
        $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                    base_url(["Admin", "dashboard"])
                               ];	        
        $this->_view("manageTable",$data);                
    }

    public function exportTable($table_name, $confirm = "0"){

        $util_model     = new UtilModel;
        $dbutil_model   = new DbutilModel;
        $file_model     = new FileModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        if( $confirm === "0" ){

            $data    =  [   "page_title"=>"ยืนยันการส่งออกตาราง",
                            "what_happened"=>"ท่านกำลังส่งออกตารางข้อมูล <strong>$table_name</strong> ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","exportTable",$table_name, 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => $this->_get_backlink() ,
                        ];  		

            $this->_view("confirm",$data);

        }else{

            $arr_row        = $dbutil_model->get_all_row_Of_table($table_name);
            
            $arr_column     = $dbutil_model->get_column_of_table($table_name);

            $line_column    = $util_model->get_line_of_text_from_array (
                                                        $arr_column, 
                                                        "\t" 
                                                    );
            $i = 1;
            do {
                $start = ($i - 1) * 10000;
                $arr_row_for_file = array_slice($arr_row, $start, 10000);

                $txt_data = $util_model->get_text_data_from_array_of_object(
                            $arr_row_for_file,$arr_column);

                // Write to file
                $file_model->create_file( ASSETPATH."03get_text_file_from_table/".$table_name."$i.txt" );
                $file_model->write_to_file( ASSETPATH."03get_text_file_from_table/".$table_name."$i.txt" , 
                                            $table_name."\n".$line_column."\n".$txt_data ) ;
                $i = $i + 1;

            } while ( count( $arr_row_for_file ) == 10000);

            $what_happened =  "ท่านกำลังส่งออกตารางชื่อ $table_name <br>";
            $what_happened .= "ตาวโหลดได้ที่ ".ASSETPATH."03get_text_file_from_table/".$table_name."[x].txt";
            $data	=  [    "page_title"=>"บัตรคำได้ส่งออกเรียบร้อยแล้ว",
                            "what_happened"=>$what_happened,
                            "what_todo" => "กรุณาดาวน์โหลดเพื่อนำไปใช้งานต่อไป",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Admin", "manageTable"])
                        ];
            $this->_warn($data);            

        }
    }

    public function addBlankCard(){

        $card_model = new CardModel;

        if( ($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level  === "3" )
        {
        }else{
            $this->_needToBeAdmin();
            return;
        }

        $data["num_card"] = $card_model->get_num_by_cardgroup_id(8);

        if( ($this->request->getMethod() === "post") && !$this->request->getPost("required_num") ){     

            $data	=  [    "page_title"=>"ข้อมูลไม่ครบถ้วน",
                            "what_happened"=>"ท่านไม่ได้ระบุจำนวนบัตรคำที่ต้องการ",
                            "what_todo" => "กรุณากลับไปกรอกข้อมูลให้ครบถ้วน",
                            "btnText_toGo" => "กลับ",
                            "btnLink_toGo" => $this->_get_backlink()
                        ];
            $this->_warn($data);

        }elseif( ($this->request->getMethod() === "post")){ 

            $required_num = $this->request->getPost("required_num");

            for( $i = $data["num_card"] + 1; $i <= $required_num; $i++) {
                $card_model->insert_blank_card();
            }

            $num_card = $card_model->get_num_by_cardgroup_id(8);

            $data	=  [    "page_title"=>"บัตรคำได้เพิ่มเรียบร้อยแล้ว",
                            "what_happened"=>"ตอนนี้ท่านมีบัตรคำจำนวน $num_card ข้อ",
                            "what_todo" => "คลิ๊กปุ่ม [กลับ] เพื่อกลับสู่ส่วน เพิ่มบัตรคำเปล่า ",
                            "btnText_toGo" => "กลับ",
                            "btnLink_toGo" => $this->_get_backlink()
                        ];
            $this->_warn($data);            

        }else{

            $data["page_title"] = 	"เพิ่มบัตรคำเปล่า"; 
            $data["page_link"] 	= 	[	"แดชบอร์ดของผู้ดูแลระบบ",
                                        base_url(["Admin", "dashboard"])
                                   ];	        
            $this->_view("addBlankCard",$data);                            
        }
    }
}

