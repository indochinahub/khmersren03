<div class="box">
    <div class="box__head box__head--info">
        คำสั่ง
    </div>
    <div class="box__body box__body--info">
        <?php foreach ($arr_command as $key => $command) {
    if ($command && $key === 0) {
        echo "<strong>$command->html</strong>";
    } elseif ($command) {
        echo "<br>" . $command->html;
    }
}
?>
    </div>
</div>

<?php if ($arr_answer[0] || $arr_answer[1] || $arr_answer[2]) {?>
    <div class="accordion" id="accordionExample">
        <div class="box">
            <div class="box__head box__head--warning" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-block text-center" type="button" data-toggle="collapse"
                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                    style="color:white;font-size:1rem">
                        [ คลิ๊กเพื่อตรวจคำตอบ ]
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="box__body box__body--warning">
                    <?php foreach ($arr_answer as $key => $answer) {
    if ($answer && $key === 0) {
        echo $answer->html;
    } elseif ($answer) {
        echo "<br>" . $answer->html;
    }
}
    ?>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<div class="box">
    <div class="box__head box__head--info">
        ตัวเลือก
    </div>

    <?php foreach ($arr_choice as $choice) {?>

        <?php if ($choice->a !== false) {?>

            <?php if ($page === "b" && $choice->key === 0) {
    $style = "background-color:#edffe2;";
} elseif ($page === "b" && $choice->key === $selected_choice) {
    $style = "background-color:#f7abb3";
} elseif ($page === "b") {
    $style = "";
}
    ?>

            <?php if ($choice->a) {?>

                <div class="box__body box__body--info" style="<?php if ($page === "b") {echo $style;}?>">
                    <div>
                        <?php if ($choice->a) {echo $choice->a->html;}?>
                        <?php if ($choice->b) {echo "<br>" . $choice->b->html;}?>
                        <?php if (($choice->c) && ($page === "b")) {echo "<br>" . $choice->c->html;}?>
                        <?php if (($choice->d) && ($page === "b")) {echo "<br>" . $choice->d->html;}?>
                    </div>

                    <?php if ($page === "a") {?>
                        <div class="two_flex_column">
                            <div>
                            </div>
                            <div>
                                <a href="<?php echo base_url(array_merge(["Card", "show", "b", $card->card_id, $deck->deck_id], $key_of_choices, [$choice->key])); ?>" class="btn btn-primary">เลือก</a>
                            </div>
                        </div>
                    <?php }?>
                </div>

            <?php }?>

        <?php }?>

    <?php }?>
<div>


<?php if ($page === "b" && ($selected_choice === 0)) {?>

    <div class="box">
        <div class="box__head box__head--success">
            ผล
        </div>
        <div class="box__body box__body--success">
            <div>คำตอบ<strrong>ถูกต้อง</strong></div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>

                    <?php if ($next_card_id === false) {?>
                        <a href="<?php echo base_url(["Deck", "show", $deck->deck_id]); ?>" class="btn btn-primary">ไปชุดบัตรคำ</a>
                    <?php } else {?>
                        <a href="<?php echo base_url(["Card", "show", "a", $next_card_id, $deck->deck_id]); ?>" class="btn btn-primary">ไป</a>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>

<?php } elseif ($page === "b") {?>

    <div class="box">
        <div class="box__head box__head--danger">
            ผล
        </div>
        <div class="box__body box__body--danger">
            <div>คำตอบ<strrong>ไม่ถูกต้อง</strong></div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>

                    <?php if ($next_card_id === false) {?>
                        <a href="<?php echo base_url(["Deck", "show", $deck->deck_id]); ?>" class="btn btn-primary">ไปชุดบัตรคำ</a>
                    <?php } else {?>
                        <a href="<?php echo base_url(["Card", "show", "a", $next_card_id, $deck->deck_id]); ?>" class="btn btn-primary">ไป</a>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>

<?php }?>



<div class="box">

    <div class="box__head box__head--info">
        สถิติ
    </div>

    <div class="box__body box__body--info">

        <div class="two_flex_column">
            <div>
                จำนวนบัตรคำ
            </div>
            <div>
                <?php echo $num_user_card . "/" . $num_all_card; ?>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                <strong>บัตรคำรอทบทวนวันนี้/พรุ่งนี้</strong>
            </div>
            <div>
                <strong><?php echo $card_to_review_today . "/" . $card_to_review_tomorrow; ?></strong>
            </div>
        </div>

        <?php if ($practice) {?>
            <div class="two_flex_column">
                <div>
                    ช่วงเวลา
                </div>
                <div>
                    <?php echo $card_interval; ?> วัน
                </div>
            </div>

            <div class="two_flex_column">
                <div>
                    เวลาทบทวนครั้งถัดไป
                </div>
                <div>
                    <?php echo $next_visit_date; ?>
                </div>
            </div>

            <?php if ($page === "b") {?>

                <div class="two_flex_column">
                    <div>
                        เวลาที่ใช้
                    </div>
                    <div>
                        <?php echo $time_spent; ?>
                    </div>
                </div>

            <?php }?>

        <?php }?>

    </div>

</div>

<?php if ($page === "b") {?>

    <div class="box">
        <div class="box__head box__head--info">ความคิดเห็น</div>

        <?php foreach ($arr_cardcomment as $cardcomment) {?>
            <div class="box__body box__body--info">
                <div>
                <strong> ความเห็น </strong> :: <?php echo nl2br($cardcomment->cardcomment_text); ?><br>
                    โดย :: [ <strong><?php echo $cardcomment->owner_name; ?></strong> ] เมื่อ <?php echo $cardcomment->cardcomment_createtime; ?>
                </div>

                <?php if (($cardcomment->relation === "i_am_owner") || ($cardcomment->relation === "i_am_admin")) {?>

                    <div class="two_flex_column">
                        <div>

                        </div>
                        <div>
                        <?php if ($cardcomment->relation === "i_am_admin") {echo "[As Admin]";}?>
                            <a href="<?php echo base_url(["Cardcomment", "delete", $cardcomment->cardcomment_id]); ?>" class="btn btn-primary">ลบ</a>

                        </div>
                    </div>
                <?php }?>

            </div>
        <?php }?>

        <div class="box__body box__body--info">
            <form role="form" method="post" action="<?php echo base_url(["Cardcomment", "add", $card->card_id, $deck->deck_id]); ?>">
                <div class="form-group">
                    <label><strong>เพิ่มความเห็น</strong></label>
                    <textarea class="form-control" name="cardcomment_text" rows="2"></textarea>
                </div>
                <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">เพิ่ม</button>
                        </div>
                </div>
            </form>
        </div>
    </div>

<?php }?>



<?php if (($page === "b") && $if_user_is_admin === true) {?>

    <div class="box">
        <div class="box__head box__head--info">
            จัดการบัตรคำ
        </div>

        <div class="box__body box__body--warning">
            <div class="two_flex_column">
                <div>
                    แก้ไขบัตรคำ
                </div>
                <div>
                    <a href="<?php echo base_url(["Card", "edit", $card->card_id, $deck->deck_id]); ?>" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>

        <div class="box__body box__body--warning">
            <div class="two_flex_column">
                <div>
                    ลบบัตรคำ
                </div>
                <div>
                    <a href="<?php echo base_url(["Card", "delete", $card->card_id, $deck->deck_id]); ?>" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>

    </div>

<?php }?>

<?php if ($show_post === true) {?>
    <div class="box">
        <div class="box__head box__head--info">
            บทความที่เกี่ยวข้อง
        </div>
        <div class="box__body box__body--info">

            <div>
                <h5><?php echo $post->post_title; ?></h5>
                <h6 style="margin-top:5px">
                    [ <?php echo $post->post_createtime; ?>
                        โดย
                        <a href="<?php echo base_url(["User", "myProfile", $post_owner->user_id]); ?>">
                            <?php echo $post_owner->displayname; ?>
                        </a>]
                </h6>
            </div>

            <div style="margin-bottom:15px">
                <?php echo $post->post_intro; ?>
            </div>

            <?php if ($post->post_intro) {?>

                <div style="margin-bottom:15px">
                    <?php echo $post->post_content; ?>
                </div>

            <?php }?>

            <div class="two_flex_column">
                <div>
                    <a href="<?php echo base_url(["Post", "showBy", "Category", $postcategory->postcategory_id]); ?>">
                        <strong>#<?php echo $postcategory->postcategory_title; ?></strong>
                    </a>
                    [ <?php echo $postcategory_num_card; ?> ]
                </div>
                <div>
                </div>
            </div>











        </div>
    </div>
<?php }?>

<?php if ($show_lesson === true) {?>
    <div class="box">
        <div class="box__head box__head--info">
            บทเรียนที่เกี่ยวข้อง
        </div>

        <div class="box__body box__body--info">

            <div>
                <h5><?php echo $lesson->lesson_title; ?></h5>
                <h6 style="margin-top:5px">
                    [ <?php echo $lesson->lesson_edittime; ?> ]
                </h6>
            </div>

            <?php if ($lesson->lesson_content) {?>

                <div style="margin-bottom:15px">
                    <?php echo $lesson->lesson_content; ?>
                </div>

            <?php }?>

            <div class="two_flex_column">
                <div>
                    ไปวิชา <a href="<?php echo base_url(["Course", "show", $course->course_id]); ?>">
                        <strong><?php echo $course->course_code . " :: " . $course->course_name; ?></strong>
                    </a>
                </div>
                <div>
                </div>
            </div>
        </div>
    </div>
<?php }?>