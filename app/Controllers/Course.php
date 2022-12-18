<?php

namespace App\Controllers;

use App\Models\CardModel;
use App\Models\CourseModel;
use App\Models\CourseTypeModel;
use App\Models\DeckModel;
use App\Models\LessonModel;
use App\Models\MediaModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\UtilModel;

class Course extends MyController
{
    public function showAll()
    {
        $coursetype_model = new CourseTypeModel();
        $course_model     = new CourseModel();
        $util_model       = new UtilModel();

        $arr_course_origin = $course_model->get_all_row();
        $arr_course_origin = $util_model->sort_array_of_object_by_the_property(
            $arr_course_origin,
            "course_sort",
            $order_by = "asc"
        );
        $arr_course = [];
        foreach ($arr_course_origin as $course) {
            $course->icon_url = $course_model->get_thumbnail_url($course->course_picture01);
            array_push($arr_course, $course);
        }

        $arr_coursetype = $coursetype_model->get_all_row();

        $data["arr_coursetype"] = [];
        foreach ($arr_coursetype as $coursetype) {
            $arr_course_of_coursetype = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                $origin_arr_object = $arr_course,
                $property_name = "id_coursetype",
                $text_to_compare = $coursetype->coursetype_id,
                $operator = "==");

            if (count($arr_course_of_coursetype) > 0) {
                $arr_course_as_row = $this->util_model->separate_array_to_pair_value($arr_course_of_coursetype);

                $coursetype->arr_course_as_row = $arr_course_as_row;
                array_push($data["arr_coursetype"], $coursetype);
            }
        }

        $data["page_title"] = "วิชาทั้งหมด";
        $data["page_link"]  = ["Home",
            base_url()
        ];
        $this->_view("showAll", $data);
    }

    public function show($course_id)
    {
        $course_model   = new CourseModel;
        $deck_model     = new DeckModel;
        $card_model     = new CardModel;
        $practice_model = new PracticeModel;
        $util_model     = new UtilModel;
        $user_model     = new UserModel;
        $lesson_model   = new LessonModel;

        $data = [];
        if (($data["user"] = $this->_get_loggedin_user()) &&
            $data["user"]->user_level === "3") {
            $data["if_user_is_adamin"] = true;
        } else {
            $data["if_user_is_adamin"] = false;
        }

        $data["course"] = $course_model->get_by_id($course_id);
        $arr_deck       = $deck_model->get_by_course_id($course_id);

        if ($data["user"]) {
            $data["arr_deck"] = [];
            foreach ($arr_deck as $deck) {
                $deck->num_all_card = count($card_model->get_by_deck_id($deck->deck_id));
                $arr_practice       = $practice_model->get_by_deck_id_user_id(
                    $deck->deck_id,
                    $data["user"]->user_id);
                $deck->num_user_card        = count($arr_practice);
                $deck->card_to_review_today = count($practice_model->get_to_review(
                    $deck_id = $deck->deck_id,
                    $user_id = $data["user"]->user_id,
                    $unix_timestamp = time(),
                    $next_day = 0)
                );
                $deck->card_to_review_tomorrow = count($practice_model->get_to_review(
                    $deck_id = $deck->deck_id,
                    $user_id = $data["user"]->user_id,
                    $unix_timestamp = time(),
                    $next_day = 1)
                );
                $deck->avarage_card_interval = (int) $util_model->get_average_property_of_arr_object(
                    $arr_object = $arr_practice,
                    $property = "practice_intervalDay"
                );
                array_push($data["arr_deck"], $deck);
            }
        } else {
            $data["arr_deck"] = [];
        }

        // Show Lesson
        $arr_lesson = $lesson_model->get_by_course_id($course_id);

        $data["arr_lesson"] = [];
        foreach ($arr_lesson as $lesson) {
            $lesson->thumnail_url = $lesson_model->get_thumbnail_url($data["course"]->course_picture02);
            //$lesson->thumnail_url = "http://127.0.0.1/khmersren03/asset/site_image/banner.jpg";
            array_push($data["arr_lesson"], $lesson);
        }

        $num_row_of_lesson          = floor(count($data["arr_lesson"]) / 3) + 1;
        $data["arr_lesson_to_show"] = $util_model->saparate_array_to_row(
            $data["arr_lesson"],
            $num_row_of_lesson,
            3
        );
        // View Section
        $data["page_title"] = "วิชา " . $data["course"]->course_code . " " . $data["course"]->course_name;
        $data["page_link"]  = ["All Courses", base_url(["Course", "showAll"])];
        $this->_view("show", $data);
    }

    public function addEdit($task, $id = "0")
    {
        $course_model     = new CourseModel;
        $coursetype_model = new CoursetypeModel;
        $util_model       = new UtilModel;

        if (($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level === "3") {
        } else {
            $this->_needToBeAdmin();
            return;
        }

        // 01/06 Validation Rules and Default Value
        $data["display_media_part"] = false;
        $validattion_rules          = [
            "course_sort"      => "required",
            "course_code"      => "required|min_length[4]|max_length[15]",
            "course_shortname" => "required|min_length[4]|max_length[30]",
            "course_name"      => "required|min_length[4]|max_length[120]"
        ];

        $arr_coursetype = $coursetype_model->get_all_row();

        $data["course_id"]        = "";
        $data["course_sort"]      = "";
        $data["course_code"]      = "";
        $data["course_shortname"] = "";
        $data["course_name"]      = "";
        $data["course_download"]  = "";
        $data["id_coursetype"]    = "";

        // 02/06 Update data
        if (($this->request->getMethod() === "post") && $task === "edit" &&
            $this->validate($validattion_rules)
        ) {
            $detail = [
                "course_sort"      => trim($this->request->getPost("course_sort")),
                "course_code"      => trim($this->request->getPost("course_code")),
                "course_shortname" => trim($this->request->getPost("course_shortname")),
                "course_name"      => trim($this->request->getPost("course_name")),
                "course_download"  => trim($this->request->getPost("course_download")),
                "id_coursetype"    => trim($this->request->getPost("id_coursetype"))
            ];

            $course_model->update_by_id($id, $detail);
            return redirect()->to(base_url(["Course", "manage"]));

            // 03/06 Insert data
        } elseif (($this->request->getMethod() === "post") && ($task === "new") &&
            $this->validate($validattion_rules)
        ) {
            $detail = [
                "course_sort"      => trim($this->request->getPost("course_sort")),
                "course_code"      => trim($this->request->getPost("course_code")),
                "course_shortname" => trim($this->request->getPost("course_shortname")),
                "course_name"      => trim($this->request->getPost("course_name")),
                "course_download"  => trim($this->request->getPost("course_download")),
                "id_coursetype"    => trim($this->request->getPost("id_coursetype"))
            ];

            $course_model->insert($detail);
            return redirect()->to(base_url(["Course", "manage"]));

            // 04/06 Show form with error
        } elseif (($this->request->getMethod() === "post")) {
            $data["course_sort"]      = trim($this->request->getPost("course_sort"));
            $data["course_code"]      = trim($this->request->getPost("course_code"));
            $data["course_shortname"] = trim($this->request->getPost("course_shortname"));
            $data["course_name"]      = trim($this->request->getPost("course_name"));
            $data["course_download"]  = trim($this->request->getPost("course_download"));
            $data["id_coursetype"]    = trim($this->request->getPost("id_coursetype"));

            $data["arr_coursetype"] = [];
            foreach ($arr_coursetype as $coursetype) {
                $coursetype->selected_text = "";
                array_push($data["arr_coursetype"], $coursetype);
            }

            $data["course_sort_error"]      = $this->validator->getError('course_sort');
            $data["course_code_error"]      = $this->validator->getError('course_code');
            $data["course_shortname_error"] = $this->validator->getError('course_shortname');
            $data["course_name_error"]      = $this->validator->getError('course_name');

            $data["page_title"] = "แก้ไขวิชา ";
            $data["page_link"]  = ["กลับ", $this->_get_backlink()];
            $this->_view("addEdit", $data);

            // 05/06 Show form to edit
        } elseif ($task === "edit") {
            $data["display_media_part"] = true;

            $course = $course_model->get_by_id($id);

            $data["course_id"]        = $course->course_id;
            $data["course_sort"]      = $course->course_sort;
            $data["course_code"]      = $course->course_code;
            $data["course_shortname"] = $course->course_shortname;
            $data["course_name"]      = $course->course_name;
            $data["course_download"]  = $course->course_download;
            $data["id_coursetype"]    = $course->id_coursetype;

            $data["arr_coursetype"] = [];
            foreach ($arr_coursetype as $coursetype) {
                if ($course->id_coursetype == $coursetype->coursetype_id) {
                    $coursetype->selected_text = "selected";
                } else {
                    $coursetype->selected_text = "";
                }
                array_push($data["arr_coursetype"], $coursetype);
            }

            $media_model                  = new MediaModel($course, "course");
            $data["arr_picture"]          = $media_model->get_arr_picture();
            $data["first_vacant_picture"] = $media_model->get_first_vacant_picture_slot("picture");

            $data["page_title"] = "แก้ไขวิชา ";
            $data["page_link"]  = ["กลับ", $this->_get_backlink()];
            $this->_view("addEdit", $data);

            // 05/05 Show new form
        } elseif ($task === "new") {
            $data["arr_coursetype"] = [];
            foreach ($arr_coursetype as $coursetype) {
                $coursetype->selected_text = "selected";
                array_push($data["arr_coursetype"], $coursetype);
            }

            $data["page_title"] = "เพิ่มวิชา ";
            $data["page_link"]  = ["กลับ", $this->_get_backlink()];
            $this->_view("addEdit", $data);
        }
    }

    public function delete($course_id, $confirm = "0")
    {
        $course_model = new CourseModel;
        $course       = $course_model->get_by_id($course_id);

        if ($confirm === "1") {
            $course_model->delete_by_id($course_id);
            return redirect()->to(base_url(["Course", "manage"]));
        } else {
            $data = ["page_title" => "ยืนยันการลบวิชา",
                "what_happened"       => "คุณกำลังลบวิชา " . $course->course_code . " :: " . $course->course_name,
                "what_todo"           => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                "btnText_toConfirm"   => "ยืนยัน",
                "btnLink_toConfirm"   => base_url(["Course", "delete", $course_id, 1]),
                "btnText_toCancle"    => "ยกเลิก",
                "btnLink_toCancle"    => $this->_get_backlink()
            ];

            $this->_confirm($data);
        }
    }

    public function manage()
    {
        $course_model     = new CourseModel;
        $util_model       = new UtilModel;
        $coursetype_model = new CoursetypeModel;

        if (($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level === "3") {
        } else {
            $this->_needToBeAdmin();
            return;
        }

        $arr_course = $course_model->get_all_row();

        $arr_course = $util_model->sort_array_of_object_by_the_property(
            $arr_course,
            "course_id",
            $order_by = "desc");

        $data["arr_course"] = [];
        foreach ($arr_course as $course) {
            $coursetype              = $coursetype_model->get_by_id($course->id_coursetype);
            $course->coursetype_name = $coursetype->coursetype_name;
            array_push($data["arr_course"], $course);
        }

        $data["page_title"] = "จัดการวิชา";
        $data["page_link"]  = ["ก่อนหน้า",
            $this->_get_backlink()
        ];
        $this->_view("manage", $data);
    }
}
