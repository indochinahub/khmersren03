<?php

namespace App\Controllers;

use \App\Models\UserModel;
use \App\Models\DeckModel;
use \App\Models\CourseModel;
use \App\Models\PracticeModel;
use \App\Models\CardModel;
use \App\Models\StatisticModel;
use \App\Models\DatetimeModel;
use \App\Models\UtilModel;
use \App\Models\PostModel;
use \App\Models\MediaModel;
use \App\Models\PostcategoryModel;
use \App\Models\PaginationModel;
use \App\Models\FollowModel;
use \App\Models\MessageModel;


class Apply extends MyController
{
    public function register(){

        if( $data["user"] = $this->_get_loggedin_user() ){
            return redirect()->to(base_url(["User","logout"]));		
        }

		$validattion_rules = 	[	'user_username' => 'required|valid_email',
									'user_password' => 'required',
                                    'confirm_password' => 'required|matches[user_password]',
								];     

		// Set the task
		$data = [];
		if( ($this->request->getMethod() === "post") && ($this->validate($validattion_rules)) ){
			$data["task"] = "send_verification_email";
			
		}elseif( $this->request->getMethod() === "post" ){
			$data["user_username_error"] = $this->validator->getError('user_username');
			$data["user_password_error"] = $this->validator->getError('user_password');
            $data["confirm_password_error"] = $this->validator->getError('confirm_password');

			$data["task"] = "form_error";

		}else{
            
            $data["task"] = "show_blank_form";

		}

        if( $data["task"] === "send_verification_email" ){
            die();

        }elseif( $data["task"] === "form_error" ){

            $data["user_username"] = $this->request->getPost("user_username");
            $data["user_password"] = $this->request->getPost("user_password");
            $data["confirm_password"] = $this->request->getPost("confirm_password");

            $data["page_title"] = 	"ฟอร์มไม่ถูกต้อง";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("register",$data);

        }elseif( $data["task"] === "show_blank_form" ){

            $data["user_username"] = "";
            $data["user_password"] = "";
            $data["confirm_password"] = "";

            $data["page_title"] = 	"สมัครสมาชิกใหม่";
            $data["page_link"] 	= 	[	"หน้าแรก",
                                        base_url()
                                    ];	        
            $this->_view("register",$data);               

        }

        //var_dump( $data["task"] );
        //die();

        // do the task






                                




    }


}

