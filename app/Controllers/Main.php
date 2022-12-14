<?php

namespace App\Controllers;

use App\Models\DatetimeModel;
use App\Models\PaginationModel;
use App\Models\PostcategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\UtilModel;

class Main extends MyController
{
    public function index()
    {
        $post_model         = new PostModel;
        $util_model         = new UtilModel;
        $pagination_model   = new PaginationModel;
        $datetime_model     = new DatetimeModel;
        $user_model         = new UserModel;
        $postcategory_model = new PostcategoryModel;

        // User Section
        $arr_user = $user_model->get_all_row();
        $arr_user = $util_model->sort_array_of_object_by_the_property(
            $arr_user,
            "user_visittime",
            $order_by = "desc"
        );
        $arr_user = array_slice($arr_user, 0, 8);

        $data["arr_user"] = [];
        foreach ($arr_user as $user) {
            $user->avarta_url  = $user_model->get_avarta_url($user);
            $user->displayname = $user_model->get_user_displayname($user);
            array_push($data["arr_user"], $user);
        }

        $data["arr_user"] = $util_model->saparate_array_to_row(
            $data["arr_user"],
            2,
            4
        );

        // View Section
        $data["page_title"] = " ";
        $data["page_link"]  = ["",
            ""
        ];
        $this->_view("index", $data);
    }
}
