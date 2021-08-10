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
use App\Models\FileModel;
use App\Models\DateTimeModel;
use App\Models\PostcategoryModel;

class Media extends MyController
{

    public function deletePicture($table_name, $key_id, $media_num){

        $file_model = new FileModel;
        
        if( $table_name === "post" ){
            $table_model = new PostModel;
        }
        $row = $table_model->get_by_id( $key_id );

        $property = $table_name."_picture0".$media_num;
        $picture_path = ASSETPATH."media/".$table_name."_media/".$row->$property;

        $file_model->delete_file($picture_path );

        $table_model->update_by_id(  $key_id,
                                     [$property => null]
                                );
            
        return redirect()->to( $this->_get_backlink() );		
    }

    

    public function addPicture($table_name, $key_id, $media_num){

        $util_model = new UtilModel;

        $file = $this->request->getFile('myfile');

        $new_filename =  $util_model->add_leading_zero_to_number( $key_id, 5).$media_num.".".$file->getClientExtension();
        $dir = ASSETPATH."media/".$table_name."_media/";
        $file->move($dir,$new_filename);

        if( $table_name === "post" ){
            $table_model = new PostModel;
        }

        $property = $table_name."_picture0".$media_num;
        $table_model->update_by_id(  $key_id,
                                     [$property =>$new_filename]
                                );

        return redirect()->to( $this->_get_backlink() );		


        /*
        $config['upload_path']          = FCPATH."assets/temp_upload/";
        $config['file_name']            = time();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 15000;
        $config['max_width']            = 8000;
        $config['max_height']           = 8000;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('myfile')){
            return FALSE;

        }else{    
            $upload_detail = $this->upload->data();
            $type_part  = get_type_part_of_file_name($upload_detail["full_path"]);

            // Resize Image
            $this->load->model("file_model");
            $this->file_model->resize_image($upload_detail["full_path"]);

            // New Name
            $dirname = FCPATH."assets/images/".$table_name."_media/";
            $filename_without_type_part = add_leading_zero_to_string($content_id,5).$picture_number;
            $new_full_pathname = $dirname.$filename_without_type_part.".".$type_part;

            // Move picture to new directory
            rename($upload_detail["full_path"],$new_full_pathname);

            return $filename_without_type_part.".".$type_part;

        }        

        */
    }





}

