<?php

namespace App\Controllers;

use App\Models\CardcommentModel;
use App\Models\CardModel;
use App\Models\CourseModel;
use App\Models\DatetimeModel;
use App\Models\DeckModel;
use App\Models\LessonModel;
use App\Models\MediaModel;
use App\Models\PostcategoryModel;
use App\Models\PostModel;
use App\Models\PracticeModel;
use App\Models\UserModel;
use App\Models\UtilModel;

class Card extends MyController
{
    public function show($page, $card_id, $deck_id)
    {
        $deck_model         = new DeckModel;
        $course_model       = new CourseModel;
        $card_model         = new CardModel;
        $practice_model     = new PracticeModel;
        $datetime_model     = new DatetimeModel;
        $util_model         = new UtilModel;
        $cardcomment_model  = new CardcommentModel;
        $user_model         = new UserModel;
        $post_model         = new PostModel;
        $lesson_model       = new LessonModel;
        $postcategory_model = new PostcategoryModel;

        // Do something in general
        if ($data["user"] = $this->_get_loggedin_user()) {
        } else {
            $this->_needLogin();
            return;
        }

        if ($data["user"]->user_level === "3") {
            $data["if_user_is_admin"] = true;
        } else {
            $data["if_user_is_admin"] = false;
        }

        $data["deck"]     = $deck_model->get_by_id($deck_id);
        $data["course"]   = $course_model->get_by_deck_id($deck_id);
        $data["card"]     = $card_model->get_by_id($card_id);
        $data["page"]     = $page;
        $data["practice"] = $practice_model->get_by_card_id_deck_id_user_id(
            $card_id,
            $deck_id,
            $data["user"]->user_id
        );

        if ($last_visit_practice = $practice_model->get_last_by_user_id($data["user"]->user_id)) {
            $last_card_visit_unix_timestamp = $datetime_model->sql_timestamp_to_unix_timestamp(
                $last_visit_practice->practice_lastvisittime
            );
        } else {
            $last_card_visit_unix_timestamp = time() - 20;
        }

        // Command Section
        $data["arr_command"] = $card_model->get_card_command(
            $data["card"],
            $data["course"],
            $data["deck"]
        );

        // Choice Section
        if ($data["page"] === "a") {
            $data["key_of_choices"] = [0, 1, 2, 3];
            shuffle($data["key_of_choices"]);
        } elseif ($data["page"] === "b") {
            $arr_segment            = $this->uri->getSegments();
            $data["key_of_choices"] = [
                (int) $arr_segment[5],
                (int) $arr_segment[6],
                (int) $arr_segment[7],
                (int) $arr_segment[8]
            ];
            $data["selected_choice"] = (int) $arr_segment[9];
        }

        $data["arr_choice"] = $card_model->get_card_choice(
            $data["card"],
            $data["course"],
            $data["deck"],
            $data["key_of_choices"]
        );
        // Answers Section
        $data["arr_answer"] = $card_model->get_card_answer(
            $data["card"],
            $data["course"],
            $data["deck"]
        );

        // Get some value about Time
        $next_midnight_unix_timestamp = $datetime_model->get_unix_timestamp_at_midnight(
            $datetime_model->get_unix_timestamp(time(), $next_day = 1)
        );

        $next_midnight_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(
            $next_midnight_unix_timestamp
        );

        $now_sql_timestamp = $datetime_model->unix_timestamp_to_sql_timestamp(time());

        $today_date = $datetime_model->get_date_part_from_sql_timestamp($now_sql_timestamp);

        // Check if there is the practice
        if (($data["page"] === "b") && ($data["practice"] === false)) {
            $detail = ["id_deck"     => $deck_id,
                "id_card"                => $card_id,
                "id_user"                => $data["user"]->user_id,
                "practice_nextvisittime" => $next_midnight_sql_timestamp,
                "practice_timespent"     => 20
            ];
            $practice_id = $practice_model->insert($detail);

            $data["practice"] = $practice_model->get_by_id($practice_id);
        }

        // Get Page "b"
        // Update Practice
        if ($data["page"] === "b") {
            // Get the time value
            $last_visit_date = $datetime_model->get_date_part_from_sql_timestamp(
                $data["practice"]->practice_lastvisittime
            );

            $time_spent = time() - $last_card_visit_unix_timestamp;
            if ($time_spent > 180) {
                $time_spent = 20;
            }
        }

        // for New card or the card which is redone in the same day
        // Only update lastVisitDate
        if (($data["page"] === "b") && ($today_date === $last_visit_date)) {
            $detail = [
                "practice_lastvisittime" => $now_sql_timestamp
            ];

            //for the correct answer
        } elseif (($data["page"] === "b") && $data["selected_choice"] === 0) {
            $iterval_num_day = $datetime_model->get_iterval_num_day(
                $data["practice"]->practice_intervalDay,
                $data["deck"]->deck_intervalconstant
            );
            $next_visit_date = $datetime_model->unix_timestamp_to_sql_timestamp(
                $datetime_model->get_unix_timestamp_at_midnight(
                    time(),
                    $iterval_num_day
                )
            );

            $detail = [
                "practice_intervalDay"   => $iterval_num_day,
                "practice_lastvisittime" => $now_sql_timestamp,
                "practice_nextvisittime" => $next_visit_date,
                "practice_counter"       => $data["practice"]->practice_counter + 1,
                "practice_timespent"     => $time_spent
            ];

            // for the wrong answer
        } elseif (($data["page"] === "b") && $data["selected_choice"] !== 0) {
            $iterval_num_day = 2;
            $next_visit_date = $datetime_model->unix_timestamp_to_sql_timestamp(
                $datetime_model->get_unix_timestamp_at_midnight(
                    time(),
                    1
                )
            );
            $detail = [
                "practice_intervalDay"   => $iterval_num_day = $iterval_num_day,
                "practice_lastvisittime" => $now_sql_timestamp,
                "practice_nextvisittime" => $next_visit_date,
                "practice_counter"       => $data["practice"]->practice_counter + 1,
                "practice_timespent"     => $time_spent

            ];
        }

        // Update Practice
        if ($data["page"] === "b") {
            $practice_model->update_by_id($data["practice"]->practice_id,
                $detail
            );
            $data["practice"] = $practice_model->get_by_id($data["practice"]->practice_id);
        }

        // Get NextCard
        $data["next_card_id"] = $card_model->get_next_card_id(
            $data["deck"]->deck_id,
            $data["user"]->user_id,
            time()
        );

        // Statistic Section
        $data["num_all_card"] = count($card_model->get_by_deck_id($deck_id));
        $arr_practice         = $practice_model->get_by_deck_id_user_id(
            $deck_id,
            $data["user"]->user_id);
        $data["num_user_card"] = count($arr_practice);

        $data["card_to_review_today"] = count($practice_model->get_to_review(
            $deck_id,
            $data["user"]->user_id,
            time(),
            $next_day = 0
        )
        );
        $data["card_to_review_tomorrow"] = count($practice_model->get_to_review(
            $deck_id,
            $data["user"]->user_id,
            time(),
            $next_day = 1)
        );
        if ($data["practice"]) {
            $data["card_interval"] = $data["practice"]->practice_intervalDay;

            $data["next_visit_date"] = $datetime_model->get_thai_date_from_sql_timestamp(
                $datetime_model->get_date_part_from_sql_timestamp(
                    $data["practice"]->practice_nextvisittime
                )
            );
            $data["time_spent"] = $data["practice"]->practice_timespent;
        }

        // Cardcomment section
        $arr_cardcomment         = $cardcomment_model->get_by_card_id_and_deck_id($card_id, $deck_id);
        $data["arr_cardcomment"] = [];
        foreach ($arr_cardcomment as $cardcomment) {
            $cardcomment_owner       = $user_model->get_by_id($cardcomment->id_user);
            $cardcomment->owner_name = $user_model->get_user_displayname($cardcomment_owner);

            if ($data["user"]->user_id === $cardcomment_owner->user_id) {
                $cardcomment->relation = "i_am_owner";
            } elseif ($data["if_user_is_admin"] === true) {
                $cardcomment->relation = "i_am_admin";
            } else {
                $cardcomment->relation = "i_am_other";
            }

            $cardcomment->cardcomment_createtime = $datetime_model->get_thai_datetime_from_sql_timestamp($cardcomment->cardcomment_createtime);
            array_push($data["arr_cardcomment"], $cardcomment);
        }

        // Show related Post
        if ($data["card"]->id_post && $data["post"] = $post_model->get_by_id($data["card"]->id_post)) {
            $data["show_post"] = true;

            $media_model                   = new MediaModel($data["post"], "post");
            $data["post"]->post_intro      = $media_model->replace_media_tag_with_html($data["post"]->post_intro);
            $data["post"]->post_content    = $media_model->replace_media_tag_with_html($data["post"]->post_content);
            $data["post_owner"]            = $user_model->get_by_post_id($data["post"]->post_id);
            $data["postcategory"]          = $postcategory_model->get_by_post_id($data["post"]->post_id);
            $data["postcategory_num_card"] = $post_model->get_num_by_postcategory_id($data["post"]->id_postcategory);
            $data["post_createddate"]      = $datetime_model->get_thai_datetime_from_sql_timestamp(
                $data["post"]->post_createtime);
        } else {
            $data["show_post"] = false;
            $card_model->update_by_id($card_id, ["id_post" => null]);
        }

        // Show related Lesson
        if ($data["card"]->id_lesson && $data["lesson"] = $lesson_model->get_by_id($data["card"]->id_lesson)) {
            $data["show_lesson"] = true;

            $data["lesson"]->lesson_edittime = $datetime_model->get_thai_datetime_from_sql_timestamp($data["lesson"]->lesson_edittime);
            $media_model                     = new MediaModel($data["lesson"], "lesson");
            $data["lesson"]->lesson_content  = $media_model->replace_media_tag_with_html($data["lesson"]->lesson_content);
        } else {
            $data["show_lesson"] = false;
            $card_model->update_by_id($card_id, ["id_lesson" => null]);
        }

        // View Section
        $data["page_title"] = "บัตรคำ " . $data["card"]->card_sort;
        $data["page_link"]  = [
            "ชุดบัตรคำ " . $data["course"]->course_code . "-" . $data["deck"]->deck_name,
            base_url(["Deck", "show", $deck_id])

        ];
        $this->_view("show", $data);
    }

    public function delete($card_id, $deck_id, $confirm = "0")
    {
        $card_model = new CardModel;

        if (($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level === "3") {
        } else {
            $this->_needToBeAdmin();
            return;
        }

        if ($confirm === "0") {
            $data = ["page_title" => "ยืนยันการลบบัตรคำ",
                "what_happened"       => "ท่านกำลังลบบัตรคำหมายเลข $card_id ",
                "what_todo"           => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                "btnText_toConfirm"   => "ยืนยัน",
                "btnLink_toConfirm"   => base_url(["Card", "delete", $card_id, $deck_id, 1]),
                "btnText_toCancle"    => "ยกเลิก",
                "btnLink_toCancle"    => base_url(["Card", "show", "a", $card_id, $deck_id])
            ];

            $this->_view("confirm", $data);
        } else {
            $card_model->delete_by_id((int) $card_id);
            return redirect()->to(base_url(["Deck", "show", $deck_id]));
        }
    }

    public function edit($card_id, $deck_id)
    {
        $card_model   = new CardModel;
        $deck_model   = new DeckModel;
        $course_model = new CourseModel;
        $util_model   = new UtilModel;

        if (($data["user"] = $this->_get_loggedin_user())
            && $data["user"]->user_level === "3") {
        } else {
            $this->_needToBeAdmin();
            return;
        }

        $data["card"]   = $card_model->get_by_id($card_id);
        $data["deck"]   = $deck_model->get_by_id($deck_id);
        $data["course"] = $course_model->get_by_deck_id($deck_id);

        // Command Section
        $data["arr_command"] = $card_model->get_card_command(
            $data["card"],
            $data["course"],
            $data["deck"]
        );

        // Answers Section
        $data["arr_answer"] = $card_model->get_card_answer(
            $data["card"],
            $data["course"],
            $data["deck"]
        );

        // Choice Section
        $data["key_of_choices"] = [0, 1, 2, 3];
        $data["arr_choice"]     = $card_model->get_card_choice(
            $data["card"],
            $data["course"],
            $data["deck"],
            $data["key_of_choices"]
        );

        // Set the task
        if (($this->request->getMethod() === "post")) {
            $data["task"] = "do_task";
        } else {
            $data["task"] = "form_blank";
        }

        // Do the task
        if ($data["task"] === "form_blank") {
            $data["page_title"] = "แก้ไขบัตรคำ";
            $data["page_link"]  = ["หมายเลข " . $data["card"]->card_sort,
                base_url(["Card", "show", "a", $card_id, $deck_id])
            ];
            $this->_view("edit", $data);
        } elseif ($data["task"] = "do_task") {
            $detail = $this->request->getPost();
            $detail = $util_model->fill_null_in_array($detail);
            $card_model->update_by_id($card_id, $detail);

            return redirect()->to(base_url(["Card", "edit", $card_id, $deck_id]));
        }
    }
}
