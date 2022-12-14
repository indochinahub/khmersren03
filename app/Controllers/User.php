<?php

namespace App\Controllers;

use \App\Models\CardModel;
use \App\Models\CourseModel;
use \App\Models\DatetimeModel;
use \App\Models\DeckModel;
use \App\Models\FollowModel;
use \App\Models\MediaModel;
use \App\Models\MessageModel;
use \App\Models\PaginationModel;
use \App\Models\PostcategoryModel;
use \App\Models\PostModel;
use \App\Models\PracticeModel;
use \App\Models\StatisticModel;
use \App\Models\UserModel;
use \App\Models\UtilModel;

class User extends MyController
{
    public function login()
    {
        $user_model = new UserModel();

        $validattion_rules = ['username' => 'required',
            'password'                       => 'required'
        ];

        // Set the task
        $data = [];
        if (($this->request->getMethod() === "post") && ($this->validate($validattion_rules))) {
            $data["task"] = "validate_user";
        } elseif ($this->request->getMethod() === "post") {
            $data["username_error"] = $this->validator->getError('username');
            $data["password_error"] = $this->validator->getError('password');
            $data["task"]           = "form_error";
        } else {
            $data["task"] = "form_blank";
        }

        // Do the task
        if ($data["task"] === "form_blank") {
            // Clear session
            $this->session->remove('uid');
            if (isset($_COOKIE["uid"])) {
                setcookie('uid', $_COOKIE["uid"], time() - (86400 * 7), "/");
            }

            $data["username"] = "";

            $data["page_title"] = "Login";
            $data["page_link"]  = ["Home",
                base_url()
            ];
            $this->_view("login", $data);
        } elseif ($data["task"] === "form_error") {
            $data["page_title"] = "Login";
            $data["page_link"]  = ["Home",
                base_url()
            ];
            $this->_view("login", $data);
        } elseif ($data["task"] === "validate_user") {
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            if ($user = $user_model->get_validated_user($username, $password)) {
                $this->session->set('uid', $user->user_id);

                return redirect()->to(base_url());
            } else {
                $data = ["page_title" => "รหัสผ่านไม่ถูกต้อง",
                    "what_happened"       => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
                    "what_todo"           => "กรุณาตรวจสอบชื่อผู้ใช้และรหัสผ่านใหม่และเข้าสู่ระบบอีกครั้ง",
                    "btnText_toGo"        => "Back",
                    "btnLink_toGo"        => base_url(["User", "login"])
                ];
                $this->_warn($data);
            }
        }
    }

    public function logout()
    {
        $this->session->remove('uid');
        if (isset($_COOKIE["uid"])) {
            setcookie('uid', $_COOKIE["uid"], time() - (86400 * 7), "/");
        }
        return redirect()->to(base_url(["User", "login"]));
    }

    public function myProfile($member_id)
    {
        $deck_model         = new DeckModel;
        $course_model       = new CourseModel;
        $card_model         = new CardModel;
        $practice_model     = new PracticeModel;
        $statistic_model    = new StatisticModel;
        $datetime_model     = new DatetimeModel;
        $util_model         = new UtilModel;
        $user_model         = new UserModel;
        $post_model         = new PostModel;
        $postcategory_model = new PostcategoryModel;
        $follow_model       = new FollowModel;
        $message_model      = new MessageModel;

        $data["user"]   = $this->_get_loggedin_user();
        $data["member"] = $user_model->get_user_by_id($member_id);

        if ($data["user"] && ($data["user"]->user_id === $data["member"]->user_id)) {
            $data["if_user_view_own_profile"] = true;
        } else {
            $data["if_user_view_own_profile"] = false;
        }

        // Follow Part
        if ($data["user"] && ($data["if_user_view_own_profile"] === false)) {
            $data["relation_text"] = $follow_model->get_my_relation_with_other(
                $data["user"]->user_id,
                $data["member"]->user_id
            );
            $data["other_displayname"]             = $user_model->get_user_displayname($data["member"]);
            $data["num_unread_message_with_other"] = $message_model->get_num_unread_message($data["user"]->user_id, $data["member"]->user_id);
        }

        // Statistic Section
        $data["today_date"] = $datetime_model->get_thai_date_from_sql_timestamp(
            $datetime_model->unix_timestamp_to_sql_timestamp(time())
        );
        $data["num_day_from_start"]            = $statistic_model->get_num_day_from_start($data["member"]->user_id);
        $data["num_day_of_statistic"]          = count($statistic_model->get_daily_statistic($data["member"]->user_id));
        $data["total_timespent_of_user"]       = $datetime_model->get_second_in_minute_and_hour($statistic_model->get_total_timespent_of_user($data["member"]->user_id));
        $data["last_visit_time"]               = $datetime_model->get_thai_datetime_from_sql_timestamp($data["member"]->user_visittime);
        $data["num_practice_have_done_today"]  = $practice_model->get_num_practice_have_done_of_the_day($data["member"]->user_id, time());
        $data["timespent_today"]               = $datetime_model->get_second_in_minute_and_hour($practice_model->get_timespent_of_the_day($data["member"]->user_id, time()));
        $data["total_card_to_review_today"]    = $practice_model->get_total_num_to_review($data["member"]->user_id, time(), 1);
        $data["total_card_to_review_tomorrow"] = $practice_model->get_total_num_to_review($data["member"]->user_id, time(), 2);

        $last_15_day_statistic = $statistic_model->get_last_15_day_statistic($data["member"]->user_id, time());

        $data["num_visit_last_15_day"] = 0;
        $timespent_last_15_day         = 0;
        $num_card_last_15_day          = 0;
        foreach ($last_15_day_statistic as $statistic) {
            if ($statistic->num_card !== 0) {
                $data["num_visit_last_15_day"] = $data["num_visit_last_15_day"] + 1;
                $timespent_last_15_day         = $timespent_last_15_day + $statistic->timespent;
                $num_card_last_15_day          = $num_card_last_15_day + $statistic->num_card;
            }
        }

        $data["timespent_per_day_last_15_day"] = $datetime_model->get_second_in_minute_and_hour(floor($timespent_last_15_day / 15));
        $data["num_card_per_day_last_15_day"]  = floor($num_card_last_15_day / 15);
        $data["percent_of_visit_last_15_day"]  = floor(($data["num_visit_last_15_day"] / 15) * 100);

        // Deck Section
        $arr_deck = $deck_model->get_by_user_id($data["member"]->user_id);

        $data["arr_deck"]            = [];
        $data["total_num_all_card"]  = 0;
        $data["total_num_user_card"] = 0;
        foreach ($arr_deck as $deck) {
            $deck->course = $course_model->get_by_deck_id($deck->deck_id);
            array_push($data["arr_deck"], $deck);

            $deck->num_all_card         = count($card_model->get_by_deck_id($deck->deck_id));
            $data["total_num_all_card"] = $data["total_num_all_card"] + $deck->num_all_card;

            $arr_practice = $practice_model->get_by_deck_id_user_id(
                $deck->deck_id,
                $data["member"]->user_id);
            $deck->num_user_card         = count($arr_practice);
            $data["total_num_user_card"] = $data["total_num_user_card"] + $deck->num_user_card;

            $deck->card_to_review_today = count($practice_model->get_to_review(
                $deck->deck_id,
                $data["member"]->user_id,
                time(),
                $next_day = 0
            )
            );

            $deck->card_to_review_tomorrow = count($practice_model->get_to_review(
                $deck->deck_id,
                $data["member"]->user_id,
                time(),
                $next_day = 1
            )
            );

            $deck->average_card_interval = $practice_model->get_average_interval(
                $deck->deck_id,
                $data["member"]->user_id
            );

            $deck->timespent = $datetime_model->get_second_in_minute_and_hour(
                $statistic_model->get_sum_spenttime_by_user_id_and_deck_id(
                    $data["member"]->user_id,
                    $deck->deck_id
                )
            );
        }

        $data["arr_deck"] = $util_model->sort_array_of_object_by_the_property(
            $objects = $arr_deck,
            $sorted_property = "card_to_review_today",
            $order_by = "desc"
        );
        $data["arr_deck"] = array_slice($data["arr_deck"], 0, 5);

        // Member Section,
        $arr_id_whom_i_relate_to     = $follow_model->get_id_of_whom_i_relate_to($data["member"]->user_id);
        $arr_id_whom_i_not_relate_to = $follow_model->get_id_of_whom_i_not_relate_to($data["member"]->user_id, 8);

        $arr_id_of_user_to_show = array_values(array_merge($arr_id_whom_i_relate_to, $arr_id_whom_i_not_relate_to));
        $arr_id_of_user_to_show = array_slice($arr_id_of_user_to_show, 0, 8);

        $data["arr_user_to_show"] = [];
        foreach ($arr_id_of_user_to_show as $id) {
            $user              = $user_model->get_by_id($id);
            $user->displayname = $user_model->get_user_displayname($user);
            $user->avarta_url  = $user_model->get_avarta_url($user);
            array_push($data["arr_user_to_show"], $user);
        }

        $data["arr_user_to_show"] = $util_model->sort_array_of_object_by_the_property(
            $data["arr_user_to_show"],
            "user_visittime",
            $order_by = "desc"
        );

        $data["arr_user_to_show"] = $util_model->saparate_array_to_row(
            $data["arr_user_to_show"],
            2,
            4
        );

        // View Section
        if ($data["if_user_view_own_profile"]) {
            $data["page_title"] = "โปรไฟล์ของฉัน ";
        } else {
            $data["page_title"] = "โปรไฟล์ของ " . $data["member"]->displayname;
        }

        $data["page_link"] = ["หน้าแรก",
            base_url()
        ];
        $this->_view("myProfile", $data);
    }

    public function myStatistic()
    {
        $statistic_model = new StatisticModel;
        $datetime_model  = new DatetimeModel;
        $util_model      = new UtilModel;

        $user = $this->_get_loggedin_user();

        //  Today Statistic
        $data["today_date"] = $datetime_model->get_thai_date_from_sql_timestamp(
            $datetime_model->unix_timestamp_to_sql_timestamp(time())
        );

        if ($arr_today_statistic = $statistic_model->get_now_statistic($user->user_id)) {
            $today_num_card  = 0;
            $today_timespent = 0;
            foreach ($arr_today_statistic as $today_statistic) {
                $today_num_card  = $today_num_card + $today_statistic->num_card;
                $today_timespent = $today_timespent + $today_statistic->timespent;
            }

            $today_num_card               = $today_num_card . " ข้อ";
            $today_timespent              = $datetime_model->get_second_in_minute_and_hour($today_timespent);
            $data["today_statistic_text"] = " $today_timespent <br> $today_num_card ";
        } else {
            $data["today_statistic_text"] = "[ไม่มีข้อมูล]";
        }

        // Last 15 day statistic
        $arr_daily_statistic   = $statistic_model->get_daily_statistic($user->user_id);
        $assoc_daily_statistic = $util_model->get_assoc_from_array_of_object(
            $arr_daily_statistic,
            $key_property = "statistic_datetime"
        );

        $arr_date = $datetime_model->get_last_num_day_midnight(
            time(), 15);

        $last_15_day_statistic = $statistic_model->get_last_15_day_statistic($user->user_id, time());
        $data["arr_statistic"] = [];
        foreach ($last_15_day_statistic as $statistic) {
            if (array_key_exists($statistic->date, $assoc_daily_statistic)) {
                $timespent = $datetime_model->get_second_in_minute_and_hour($statistic->timespent);
                $num_card  = $statistic->num_card . " ข้อ";

                $statistic->statistic_text = " $timespent <br> $num_card ";
            } else {
                $statistic->statistic_text = "[ไม่มีข้อมูล]";
            }

            $statistic->date = $datetime_model->get_thai_date_from_sql_timestamp(
                $statistic->date
            );

            array_push($data["arr_statistic"], $statistic);
        }

        $data["page_title"] = "สถิติของฉัน ";
        $data["page_link"]  = ["กลับ",
            $this->_get_backlink()
        ];
        $this->_view("myStatistic", $data);
    }

    public function showAll()
    {
        $user_model       = new UserModel;
        $util_model       = new UtilModel;
        $pagination_model = new PaginationModel;
        $datetime_model   = new DatetimeModel;
        $practice_model   = new PracticeModel;

        $arr_user = $user_model->get_all_row();

        $arr_user = $util_model->sort_array_of_object_by_the_property(
            $arr_user,
            "user_visittime",
            $order_by = "desc"
        );

        if (!($page = $this->request->getGet('page'))) {
            $page = 1;
        }

        $pagination = $pagination_model->get_pagination(
            $arr_user,
            $current_page = $page,
            $per_page = 10
        );
        $data["pagination_link"] = $pagination->link;
        $arr_user                = $pagination->arr_row;

        $data["arr_user"] = [];
        foreach ($arr_user as $user) {
            $user->num_card_to_review_today    = $practice_model->get_total_num_to_review($user->user_id, time(), 1);
            $user->num_card_to_review_tomorrow = $practice_model->get_total_num_to_review($user->user_id, time(), 2);

            $user->display_name   = $user_model->get_user_displayname($user);
            $user->avatar_url     = $user_model->get_avarta_url($user);
            $user->user_visittime = $datetime_model->get_thai_datetime_from_sql_timestamp($user->user_visittime);

            array_push($data["arr_user"], $user);
        }

        $data["page_title"] = "ผู้ใช้ทั้งหมด ";
        $data["page_link"]  = ["กลับ",
            $this->_get_backlink()
        ];
        $this->_view("showAll", $data);
    }

    public function editProfile()
    {
        $user_model = new UserModel;

        // Check user's previlege
        if ($data["user"] = $this->_get_loggedin_user()) {
        } else {
            $this->_needLogin();
            return;
        }

        $media_model                  = new MediaModel($data["user"], "user");
        $data["arr_picture"]          = $media_model->get_arr_picture();
        $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");

        $validattion_rules = [
            'user_password'     => 'required|numeric|min_length[4]|max_length[4]',
            "user_display_name" => 'required|min_length[6]|max_length[30]'
        ];

        // Set the task
        if (($this->request->getMethod() === "post") && ($this->validate($validattion_rules))) {
            $password     = trim($this->request->getPost("user_password"));
            $display_name = trim($this->request->getPost("user_display_name"));

            $detail = ["user_password" => $password,
                "user_display_name"        => $display_name
            ];

            $user_model->update_by_id(
                $data["user"]->user_id,
                $detail
            );
            return redirect()->to($this->_get_backlink());
        } elseif ($this->request->getMethod() === "post") {
            $data["user"]->user_password     = trim($this->request->getPost("user_password"));
            $data["user"]->user_display_name = trim($this->request->getPost("user_display_name"));

            $data["user_password_error"]     = $this->validator->getError('user_password');
            $data["user_display_name_error"] = $this->validator->getError('user_display_name');

            $data["page_title"] = "ข้อมูลผิดพลาด ";
            $data["page_link"]  = ["กลับ",
                $this->_get_backlink()
            ];
            $this->_view("editProfile", $data);
        } else {
            $data["page_title"] = "แก้ไขข้อมูลส่วนตัว ";
            $data["page_link"]  = ["กลับ",
                $this->_get_backlink()
            ];
            $this->_view("editProfile", $data);
        }
    }
}
