<?php

namespace App\Controllers;

use App\Models\CoursetypeModel;
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
use App\Models\DatetimeModel;
use App\Models\PostcategoryModel;
use App\Models\MessageModel;

class Media extends MyController
{

    public function deletePicture($table_name, $key_id, $media_num){

        $file_model = new FileModel;
        $util_model = new UtilModel;
        
        $table_model = $util_model->get_object_model_from_table_name($table_name);

        $row = $table_model->get_by_id( $key_id );

        $property = $table_name."_picture0".$media_num;
        $picture_path = ASSETPATH."media/".$table_name."_media/".$row->$property;

        $file_model->delete_file($picture_path );

        $table_model->update_by_id(  $key_id,
                                     [$property => null]
                                );
            
        return redirect()->to( $this->_get_backlink() );		
    }

    public function deleteSound($table_name, $key_id, $media_num){

        $file_model = new FileModel;
        $util_model = new UtilModel;
        
        $table_model = $util_model->get_object_model_from_table_name($table_name);

        $row = $table_model->get_by_id( $key_id );

        $property = $table_name."_sound0".$media_num;
        $picture_path = ASSETPATH."media/".$table_name."_media/".$row->$property;

        $file_model->delete_file($picture_path );

        $table_model->update_by_id(  $key_id,
                                     [$property => null]
                                );
            
        return redirect()->to( $this->_get_backlink() );        
    }

    
    public function addPicture($table_name, $key_id, $media_num){
        $util_model = new UtilModel;
        $file_model = new FileModel;
        
        // Check user's previlege
        if( $user = $this->_get_loggedin_user() ){
        }else{
            $this->_needLogin();
            return;
        }

        // get request
        $file = $this->request->getFile('myfile');

        // Add file to directory
        $dir = ASSETPATH."media/".$table_name."_media/";
        $new_filename =  $util_model->add_leading_zero_to_number( $key_id, 5).$media_num.".".$file->getClientExtension();
        $this->_addFile($file,  $dir, $new_filename ) ;

        // Resize Image
        if( $file->getClientExtension() !== "webp" ){
            $file_model->resize_image( $dir.$new_filename );
        }
        
        // Update database
        $table_model = $util_model->get_object_model_from_table_name($table_name);

        $property = $table_name."_picture0".$media_num;
        $table_model->update_by_id(  $key_id,
                                     [$property =>$new_filename]
                                );

        return redirect()->to( $this->_get_backlink() );		
    }

    public function addSound($table_name, $key_id, $media_num){
        $util_model = new UtilModel;
        $file_model = new FileModel;
        
        // get request
        $file = $this->request->getFile('myfile');

        // Add file to directory
        $dir = ASSETPATH."media/".$table_name."_media/";
        $new_filename =  $util_model->add_leading_zero_to_number( $key_id, 5).$media_num.".".$file->getClientExtension();
        $this->_addFile($file,  $dir, $new_filename ) ;

        // Update database
        $table_model = $util_model->get_object_model_from_table_name($table_name);

        $property = $table_name."_sound0".$media_num;
        $table_model->update_by_id(  $key_id,
                                     [$property =>$new_filename]
                                );

        return redirect()->to( $this->_get_backlink() );        
    }

    public function _addFile( $file_obj, $dir, $new_filename){
        $util_model = new UtilModel;
        $file_model = new FileModel;

        $file_obj->move($dir,$new_filename);

        return $dir.$new_filename;
    }

    public function deleteYoutube($table_name, $key_id, $media_num){

        $util_model = new UtilModel;

        // Update database
        $table_model = $util_model->get_object_model_from_table_name($table_name);
        
        $property = $table_name."_youtube0".$media_num;
        $table_model->update_by_id(     $key_id,
                                        [$property =>null]
                                );
        return redirect()->to( $this->_get_backlink() );    
    }

    public function addYoutube($table_name, $key_id, $media_num){

        $util_model = new UtilModel;

        // Update database
        $table_model = $util_model->get_object_model_from_table_name($table_name);        

        $youtube_id =  $this->request->getPost("youtube");

        $property = $table_name."_youtube0".$media_num;
        $table_model->update_by_id(     $key_id,
                                        [$property =>$youtube_id]
                                );
        return redirect()->to( $this->_get_backlink() );            
    }

}

