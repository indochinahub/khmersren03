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

        $user_model = new UserModel;
        $util_model = new UtilModel;

        if( $data["user"] = $this->_get_loggedin_user() ){
            return redirect()->to(base_url(["User","logout"]));		
        }

		$validattion_rules = 	[	'user_username' => 'required|valid_email',
									'user_password' => 'required|numeric|min_length[4]|max_length[4]',
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

            $username  = trim($this->request->getPost("user_username"));
            $password  = trim($this->request->getPost("user_password"));
            $activate_key = $util_model->get_random_number(4);

            if( $user = $this->user_model->get_user_by_username($username)  )  {

                $what_todo = "โดยคลิ๊กที่ปุ่ม [กลับ] เพื่อกลับไปหน้าที่แล้ว หรือไปที่ส่วน <a href='".base_url(["Apply","forgetPassword"])."'>[ลืมรหัสผ่าน]</a> ";

                $data	=   [   "page_title"=>"มีผู้ใช้อีเมล์นี้อยู่แล้ว",
                                "what_happened"=>"คุณไม่สามารถใช้งาน $username ได้",
                                "what_todo" => $what_todo,
                                "btnText_toGo" => "กลับ",
                                "btnLink_toGo" => $this->_get_backlink()
                            ];
                $this->_warn($data);    

            }else{

                $detail =   [
                                "user_username"=>$username,
                                "user_password"=>$password,
                                "user_activatekey"=>$activate_key ,
                            ];

                if( $user_id = $user_model->insert($detail) ){

                    $subject = "การยืนยันอีเมล์และรายละเอียดสำหรับใช้งาน khmersren.com";

                    $url = base_url(["Apply","activateUser",$user_id,$activate_key]);
                    $message =  "ขอบคุณที่่สมัครเข้าใช้งานเว็บไซต์ www.khmersren.com โดยมีรายละเอียดเข้าใช้งานต่อไปนี้ <br>";
                    $message .= "username : $username  <br>";
                    $message .= "password : $password  <br><br>";
                    $message .= "กรุณาคลิ๊กลิงก์ข้างล่างต่อไปนี้ เพื่อยันยันอีเมล์<br>";
                    $message .= "<a href='$url'>$url</a>";    
                    
                    $this->_sendEmail($username,$subject,$message);

                }

                $data	=   [   "page_title"=>"อีเมล์ยืนยันได้ถูกส่งไปแล้ว",
                                "what_happened"=>"อีเมล์สำหรับยืนยันได้ถูกส่งไปที่ $username ",
                                "what_todo" => "กรุณาเปิดอีเมล์และคลิ๊กลิงก์ที่ส่งให้",
                                "btnText_toGo" => "ไป",
                                "btnLink_toGo" => base_url()
                            ];
                $this->_warn($data);
            }

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
    }


    public function _sendEmail($username,$subject,$message){

        $email = \Config\Services::email();
        $config['mailType'] = 'html';
        $email->initialize($config);                    

        $email->setFrom('indochinahub@gmail.com', 'Khmersren.com');
        $email->setTo($username);
        $email->setBCC('them@their-example.com');

        $email->setSubject($subject);
        $email->setMessage($message );
        
        $email->send();   
    }


    public function  forgetPassword(){

        $user_model = new UserModel;

		$validattion_rules = 	[	
                                    'user_username' => 'required|valid_email',
								];
		// Set the task
		$data = [];
		if( ($this->request->getMethod() === "post") && ($this->validate($validattion_rules)) ){

            $username = $this->request->getPost("user_username");
            $user = $user_model->get_user_by_username($username);

            if( $user && ($user->user_active === "0") ){

                $subject = "การยืนยันอีเมล์และรายละเอียดสำหรับใช้งาน khmersren.com";

                $url = base_url(["Apply","activateUser",$user->user_id,$user->user_activatekey]);
                $message =  "ขอบคุณที่่สมัครเข้าใช้งานเว็บไซต์ www.khmersren.com โดยมีรายละเอียดเข้าใช้งานต่อไปนี้ <br>";
                $message .= "username : $username  <br>";
                $message .= "password : $user->user_password  <br><br>";
                $message .= "กรุณาคลิ๊กลิงก์ข้างล่าง เพื่อยันยันอีเมล์<br>";
                $message .= "<a href='$url'>$url</a>";    
                
                $this->_sendEmail($username,$subject,$message);

                $data	=   [   "page_title"=>"อีเมล์ยืนยันได้ถูกส่งไปแล้ว",
                                "what_happened"=>"อีเมล์สำหรับยืนยันได้ถูกส่งไปที่ $username ",
                                "what_todo" => "กรุณาเปิดอีเมล์และคลิ๊กลิงก์ที่ส่งให้",
                                "btnText_toGo" => "ไป",
                                "btnLink_toGo" => base_url()
                            ];
                $this->_warn($data);

            }elseif( $user ){

                $subject = "รายละเอียดสำหรับใช้งาน khmersren.com";
                $message =  "รหัสผ่านของเท่านสำหรับเข้าใช้งานเว็บไซต์ www.khmersren.com <br>";
                $message .= "username : $user->user_username  <br>";
                $message .= "password : $user->user_password  <br><br>";
                
                $this->_sendEmail($username,$subject,$message);

                $data	=   [   "page_title"=>"เราได้ส่งอีเมล์แจ้งรหัสผ่านไปให้ท่านแล้ว",
                                "what_happened"=>"เราได้ส่งอีเมล์แจ้งรหัสผ่านให้ท่านแล้วที่ ".$username,
                                "what_todo" => "คลิ๊กที่ปุ่ม [ไป] เพื่อเข้าสู่ระบบ",
                                "btnText_toGo" => "ไป",
                                "btnLink_toGo" => base_url(["User","login"])
                            ];
                $this->_warn($data);

            }else{
                $data	=   [   "page_title"=>"ไม่อีเมล์ในระบบ",
                                "what_happened"=>" เราไม่พบอีเมล์ $username ่ในระบบ ",
                                "what_todo" => "คลิ๊กที่ปุ่ม [กลับ] เพื่อกลับไปสู่หน้าที่แล้ว และกรอกอีเมล์ที่ถูกต้อง",
                                "btnText_toGo" => "กลับ",
                                "btnLink_toGo" => $this->_get_backlink()
                            ];
                $this->_warn($data);
            }
        }else{
            $data["page_title"] = 	"ลืมรหัสผ่าน";
            $data["page_link"] 	= 	[	"กลับ",
                                        $this->_get_backlink()
                                    ];	        
            $this->_view("forgetPassword",$data);            
        }
    }

    public function activateUser($user_id,$activate_key){

        $user_model = new UserModel;

        if(  ($user = $user_model->get_by_id($user_id) )
            && ( $user->user_activatekey  === $activate_key)
          ){

            $detail = [ "user_active" => 1  ];
            $user_model->update_by_id( $user->user_id, $detail );

            $what_happend =  "ท่านได้ยืนยันเมล์เรียบร้อยแล้ว กรุณาเข้าสู่ระบบโดยใช้ข้อมูลต่อไปนี้<br>";
            $what_happend .= " Username :: ".$user->user_username."<br>";
            $what_happend .= " Password :: ".$user->user_password."<br>";

            $data	=   [   "page_title"=>"ท่านได้ยีนยันอีเมล์แล้ว",
                            "what_happened"=>$what_happend,
                            "what_todo" => "คลิ๊กที่ปุ่ม [ไป] เพื่อเข้าสู่ระบบ",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["User","login"])
                        ];
            $this->_warn($data);

        }elseif( $user ){

            $data	=   [   "page_title"=>"รหัสสำหรับยืนยันอีเมล์ไม่ถูกต้อง",
                            "what_happened"=>"กรุณายืนยันอีเมล์อีกครั้ง",
                            "what_todo" => "ท่านสามารถยืนยันอีเมล์อีกครั้ง โดยคลิีกที่ปุ่ม [ไป] เพื่อไปหน้าลืมรหัสผ่าน",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Apply","forgetPassword"])
                        ];
            $this->_warn($data);

        }

    } 

}

