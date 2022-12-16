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

        // View Section
        $data["page_title"] = " ";
        $data["page_link"]  = ["",
            ""
        ];
        $this->_view("index", $data);
    }
}
