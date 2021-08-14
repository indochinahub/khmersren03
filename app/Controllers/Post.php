<?php

namespace App\Controllers;

use App\Models\CourseTypeModel;
use App\Models\CourseModel;
use App\Models\UtilModel;
use App\Models\DeckModel;
use App\Models\CardModel;
use App\Models\PracticeModel;
use App\Models\PaginationModel;
use App\Models\CardcommentModel;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\MediaModel;
use App\Models\DateTimeModel;
use App\Models\PostcategoryModel;

class Post extends MyController
{
    public function showBy($groupBy = "All", $id = "0"){

        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DateTimeModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;

        $data["groupBy"] = $groupBy;
        if( $data["groupBy"] === "All" ){
            $arr_post = $post_model->get_all_row();
            $page_title =  "บทความ :: ทั้งหมด ";

        }elseif( $data["groupBy"] === "User"){
            $data["member"] = $user_model->get_user_by_id($id);
            $arr_post = $post_model->get_by_user_id($id);
            $page_title =  "บทความของ :: ".$data["member"]->displayname;

            $user = $this->_get_loggedin_user();

            if( $user && ( $user->user_id ===  $data["member"]->user_id ) ){
                $data["if_user_view_own_post"] = true;
            }else{
                $data["if_user_view_own_post"] = false;
            }

        }elseif( $data["groupBy"] === "Category" ){
            $arr_post = $post_model->get_by_postcategory_id($id);
            $postcategory = $postcategory_model->get_by_id($id);
            $data["member"] = $user_model->get_user_by_id($postcategory->id_user);
            $page_title  =  "กลุ่มบทความ :: #".$postcategory->postcategory_title;
            $page_title  .= "<br>ของ :: ".$data["member"]->displayname;
            
        }

        $arr_post = $util_model->sort_array_of_object_by_the_property( 
                        $arr_post, 
                        $sorted_property = "post_id", 
                        $order_by ="desc"
                    );

        // Pagination
        if( ! ($page = $this->request->getGet('page')) ){
            $page = 1;
        }

        $pagination = $pagination_model->get_pagination( 
                                        $arr_post, 
                                        $current_page = $page , 
                                        $per_page = 10
                                    );
        $data["pagination_link"] = $pagination->link;
        $arr_post = $pagination->arr_row; 


        $data["arr_post"] = [];
        foreach( $arr_post as $post){

            $media_model        = new MediaModel( $post, "post");
            $post->post_intro   = $media_model->replace_media_tag_with_html($post->post_intro);

            $post->user = $user_model->get_by_post_id( $post->post_id );
            $post->post_createddate = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                        $post->post_createddate );
            $post->postcategory = $postcategory_model->get_by_post_id($post->post_id);
            $post->postcategory_num_card = $post_model->get_num_by_postcategory_id( $post->id_postcategory);

            //$post = $post_model->add_media_to_post($post);
            array_push( $data["arr_post"], $post);

        }

        $data["page_title"] = 	$page_title; 
        $data["page_link"] 	= 	[   "ก่อนหน้า ",
                                    $this->_get_backlink()
                               ];
                               
        $this->_view("showBy",$data);                
    }

    public function show($post_id){

        $post_model = new PostModel;
        $user_model = new UserModel;
        $postcategory_model = new PostcategoryModel;
        $datetime_model = new DateTimeModel;


        $user = $this->_get_loggedin_user();

        $data["post"]                   = $post_model->get_by_id($post_id);

        $media_model                    = new MediaModel( $data["post"], "post");
        $data["post"]->post_intro       = $media_model->replace_media_tag_with_html($data["post"]->post_intro);
        $data["post"]->post_content     = $media_model->replace_media_tag_with_html($data["post"]->post_content);
        

        $data["owner"]                  = $user_model->get_by_post_id($data["post"]->post_id);
        $data["postcategory"]           = $postcategory_model->get_by_post_id($data["post"]->post_id);
        $data["postcategory_num_card"]  = $post_model->get_num_by_postcategory_id($data["post"]->id_postcategory);
        $data["post_createddate"]       = $datetime_model->get_thai_datetime_from_sql_timestamp(
                                            $data["post"]->post_createddate );

        $data["back_link"] = $this->_get_backlink();

        // Check if user can edit/delete the post
        if( $user && ( $user->user_id === $data["owner"]->user_id || $user->user_id === "3" ) ){
            $data["deleteable"] = true;
        }else{
            $data["deleteable"] = false;
        }

        if( $user && ( $user->user_id === $data["owner"]->user_id) ){
            $data["editable"] = true;

        }else{
            $data["editable"] = false;
        }

        $data["page_title"] = 	""; 
        $data["page_link"] 	= 	[   " ",
                                    base_url()
                               ];
        $this->_view("show",$data);                        
    }

    public function delete($post_id, $confirm = "0"){
        $post_model = new PostModel;
        $user_model = new UserModel;

        $post = $post_model->get_by_id($post_id);
        $owner = $user_model->get_by_post_id($post_id);


        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        if( $user->user_id === $owner->user_id || $user->user_id === "3" ){
        }else{
            $this->_needPrivilege();
            return;
        }

        if( $confirm === "0"){

            $what_happened = "ท่านกำลังลบบทความหมายเลข $post_id <br> เรื่อง <strong> $post->post_title </strong>";

            $data    =  [   "page_title"=>"ยืนยันการลบบทความ",
                            "what_happened"=>$what_happened,
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Post", "delete", $post->post_id, 1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => $this->_get_backlink(),
                        ];  		

            $this->_view("confirm",$data);

        }elseif( $confirm === "1" ){

            $post_model->delete_by_id($post_id);
            return redirect()->to(base_url( ["Post","showBy","User", $owner->user_id]));		
        }
    }

    public function addEdit($task,$post_id = "0"){

        $post_model         = new PostModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;
        $util_model         = new UtilModel;
        $datetime_model     = new DateTimeModel;

        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        // get postcategory
        $arr_postcategory =  $postcategory_model->get_by_user_id($user->user_id); 

        
        // Set the task and validate form
        $data = [];
        if( ($this->request->getMethod() === "post") && $task === "edit"  ){
            $data["task"] = "update";

        }elseif( $task === "edit"){

            $data["post"] = $post_model->get_by_id($post_id);

            $owner = $user_model->get_by_post_id($post_id);
            if( $user->user_id === $owner->user_id ){
            }else{
                $this->_needPrivilege();
                return;
            }

            $data["task"] = "show_form_to_update";

        }elseif( ($this->request->getMethod() === "post") && ($task === "new") ){
            $data["task"] = "insert";

        }elseif( $task === "new" ){
            $data["task"] = "show_form_to_insert";
        }

        
        // Do the task
        if( $data["task"] === "show_form_to_update" ){

            // get arr_postcategory
            $data["arr_postcategory"] = [];
            foreach( $arr_postcategory as $postcategory){

                if( $postcategory->postcategory_id == $data["post"]->id_postcategory ){
                    $postcategory->checked_text = " checked ";

                }else{
                    $postcategory->checked_text = "";
                }
                array_push( $data["arr_postcategory"], $postcategory);
            }
            
            $media_model            = new MediaModel( $data["post"], "post");
            $data["arr_picture"]    = $media_model->get_arr_picture();
            $data["arr_sound"]      = $media_model->get_arr_sound();
            $data["arr_youtube"]    = $media_model->get_arr_youtube();
            $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");
            $data["first_vacant_sound"] = $media_model->get_first_vacant_picture_slot("sound");
            $data["first_vacant_youtube"] = $media_model->get_first_vacant_picture_slot("youtube");

            $data["page_title"] = 	"Edit :: ".$data["post"]->post_id; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);                        

        }elseif( $data["task"] === "update"){

            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);
            $detail["post_publisheddate"] = $datetime_model->unix_timestamp_to_sql_timestamp(time());

            $post_model->update_by_id($post_id, $detail);

            return redirect()->to(base_url(["Post","show", $post_id]));		

        }elseif( $data["task"] === "show_form_to_insert"){


            $data["post"] = $post_model->get_object_with_null_value();

            $data["arr_postcategory"] = [];
            foreach( $arr_postcategory as $postcategory){

                if( $postcategory->postcategory_defaultstatus === "1" ){
                    $postcategory->checked_text = " checked ";
                }else{
                    $postcategory->checked_text = "";
                }
                array_push( $data["arr_postcategory"], $postcategory);
            }

            $data["page_title"] = 	"Add new post "; 
            $data["page_link"] 	= 	[   "กลับ",
                                        $this->_get_backlink()
                                   ];
            $this->_view("addEdit",$data);             
            

        }elseif( $data["task"] === "insert"){

            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);

            $post_id = $post_model->insert($detail);

            return redirect()->to(base_url(["Post","show", $post_id]));		
        }

    }
    

}

