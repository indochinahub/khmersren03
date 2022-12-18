<?php

namespace App\Models;

class UserModel extends MyModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table      = "user";
        $this->primaryKey = $this->table . "_id";
    }

    // return UserObject or False
    public function get_validated_user($username, $password)
    {
        $username = $this->db->escape(trim($username));
        $password = $this->db->escape(trim($password));

        $where_clause = " WHERE user_username = " . $username . " AND user_password = " . $password;
        if ($arr_row = $this->get_where($where_clause)) {
            return $arr_row[0];
        } else {
            return false;
        }
    }

    //return Object or false
    public function get_user_by_id($user_id)
    {
        if ($user = $this->get_by_id($user_id)) {
            $user->displayname = $this->get_user_displayname($user);

            return $user;
        } else {
            return false;
        }
    }

    // return text
    public function get_user_displayname($obj_user)
    {
        if (trim($obj_user->user_display_name)) {
            return $obj_user->user_display_name;
        } else {
            $arr_text = explode("@", $obj_user->user_username);
            return $arr_text[0];
        }
    }

    //return URL
    public function get_avarta_url($user_obj)
    {
        if ($user_obj->user_picture01) {
            return base_url(["asset", "media", "user_media", $user_obj->user_picture01]);
        } else {
            return base_url(["asset", "media", "user_media", "anonymous.jpg"]);
        }
    }

    // return affected rows
    public function update_visit_time($user_id)
    {
        $datetime_model = new DatetimeModel;

        $detail = [
            "user_visittime" => $datetime_model->unix_timestamp_to_sql_timestamp(time())
        ];

        return $this->update_by_id($user_id, $detail);
    }

    // return object or false
    public function get_by_post_id($post_id)
    {
        $postcategory_model = new PostcategoryModel;
        if (!($postcategory = $postcategory_model->get_by_post_id($post_id))) {return false;}

        return $this->get_user_by_id($postcategory->id_user);
    }

    public function run_one_time_a_day($user_id)
    {
        $statistic_model = new StatisticModel;

        return $statistic_model->create_daily_statistic($user_id, time());
    }

    // return user object or false
    public function get_user_by_username($username)
    {
        $username = strtolower($username);

        $where_clause = " WHERE user_username = '" . $username . "' ";
        if ($arr_user = $this->get_where($where_clause)) {
            return $arr_user[0];
        } else {
            return false;
        }
    }
}
