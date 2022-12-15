<?php if ($user && ($if_user_view_own_profile === false)) {?>

    <div class="box">

        <div class="box__body box__body--info">
            <?php if ($relation_text === "we_folow_each_other") {?>
                <strong><?php echo $other_displayname; ?></strong> และฉันติดตามซึ่งกันและกัน<br>
            <?php } elseif ($relation_text === "i_folow_the_other") {?>
                ฉันเป็นผู้ติดตามของ <strong><?php echo $other_displayname; ?></strong><br>
            <?php } elseif ($relation_text === "the_other_follow_me") {?>
                <strong><?php echo $other_displayname; ?></strong> เป็นผู้ติดตามฉัน<br>
            <?php } elseif ($relation_text === "we_have_no_relation") {?>
                ฉันและ <strong><?php echo $other_displayname; ?></strong> ไม่มีความสัมพันธ์กัน<br>
            <?php }?>
        </div>

        <?php if (($relation_text === "we_folow_each_other") || ($relation_text === "i_folow_the_other")) {?>

            <div class="box__body box__body--info">
                <div class="two_flex_column">
                    <div>
                    เลิกติดตาม <strong><?php echo $other_displayname; ?></strong>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Follow", "unfollow", $user->user_id, $member->user_id]); ?>" class="btn btn-warning">เลิก</a>
                    </div>
                </div>
            </div>

        <?php } elseif (($relation_text === "the_other_follow_me") || ($relation_text === "we_have_no_relation")) {?>

            <div class="box__body box__body--info">
                <div class="two_flex_column">
                    <div>
                        ติดตาม <strong><?php echo $other_displayname; ?></strong>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Follow", "follow", $user->user_id, $member->user_id]); ?>" class="btn btn-primary">ติดตาม</a>
                    </div>
                </div>
            </div>

        <?php }?>


        <div class="box__body box__body--info">
            <div class="two_flex_column">
                <div>
                    ข้อความส่วนตัวของคุณกับ <strong><?php echo $other_displayname; ?></strong>
                    <?php if ($num_unread_message_with_other > 0) {echo "[$num_unread_message_with_other]";}?>
                </div>
                <div>
                    <a href="<?php echo base_url(["Message", "with", $member->user_id]); ?>" class="btn btn-primary">ไป</a>

                </div>
            </div>
        </div>
    </div>

<?php }?>

<?php if ($if_user_view_own_profile === true) {?>

    <div class="box">

        <div class="row3icon">

            <div class="row3icon_icon">
                <a href="<?php echo base_url(["Message", "myMessage"]); ?>">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "01_directmsg.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        ข้อความส่วนตัว
                    </div>
                </a>
            </div>

            <div class="row3icon_icon">
                <a href="<?php echo base_url(["Deck", "myDeck", $user->user_id]); ?>">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "02_mydeck.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        บัตรคำของฉัน
                    </div>
                </a>
            </div>

            <div class="row3icon_icon">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "03_mypost.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        บทความของฉันxxx
                    </div>
            </div>
        </div>

        <div class="row3icon">

            <div class="row3icon_icon">
                <a href="<?php echo base_url(["Follow", "myFollow", $user->user_id]); ?>">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "04_myfirend.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        ผู้ที่เกี่ยวข้องกับฉัน
                    </div>
                </a>
            </div>

            <div class="row3icon_icon">
                <a href="<?php echo base_url(["User", "myStatistic"]); ?>">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "05_mystatistic.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        สถิติของฉัน
                    </div>
                </a>
            </div>

            <div class="row3icon_icon">
                <a href="<?php echo base_url(["User", "editProfile"]); ?>">
                    <div>
                        <img class="card-img-top" src="<?php echo base_url(["asset", "site_image", "06_editprofile.png"]); ?>">
                    </div>
                    <div style="text-align:center">
                        แก้ไขข้อมูลส่วนตัว
                    </div>
                </a>
            </div>

        </div>




    </div>

<?php }?>

<div class="box">
    <div class="box__head box__head--info">
        บัตรคำของ <?php if ($if_user_view_own_profile === true) {echo "ฉัน";} else {echo $member->displayname;}?>
    </div>
</div>

<div class="box">

    <div class="box__body box__body--warning">

        <div class="two_flex_column">
            <div>
                <h5>สถิติย้อนหลังตั้งแต่เริ่มต้น</h5>
            </div>
            <div>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                บัตรคำที่ทำได้/ทั้งหมด
            </div>
            <div>
                <?php echo $total_num_user_card . "/" . $total_num_all_card; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนวันที่เข้าใช้งาน/จำนวนวันจากวันแรก
            </div>
            <div>
                <?php echo $num_day_of_statistic . "/" . $num_day_from_start; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาทั้งหมดที่ทำบัตรคำ
            </div>
            <div>
                <?php echo $total_timespent_of_user; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่เข้าสู่ระบบล่าสุด
            </div>
            <div>
                <?php echo $last_visit_time; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="margin-bottom:5px;">
                <h5>สถิติย้อนหลัง 15 วัน </h5>
            </div>
            <div>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนวันที่เข้าสู่ระบบ
            </div>
            <div>
                <?php echo $num_visit_last_15_day . "/15"; ?> วัน
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                ร้อยละวันที่เข้าสู่ระบบ
            </div>
            <div>
                <?php echo $percent_of_visit_last_15_day; ?>%
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนเฉลี่ยบัตรคำที่ทำได้ต่อวัน
            </div>
            <div>
                <?php echo $num_card_per_day_last_15_day; ?> ข้อ/วัน
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาเฉลี่ยที่ใช้ทำบัตรคำต่อวัน
            </div>
            <div>
                <?php echo $timespent_per_day_last_15_day; ?>/วัน
            </div>
        </div>
        <div class="two_flex_column">
            <div style="margin-bottom:5px;">
                <h5>สถิติวันนี้ <?php echo $today_date; ?></h5>
            </div>
            <div>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                บัตรคำรอทบทวน
            </div>
            <div>
                <?php echo $total_card_to_review_today . "/" . $total_card_to_review_tomorrow; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนบัตรคำที่ทำได้
            </div>
            <div>
                <?php echo $num_practice_have_done_today; ?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่ใช้ทำบัตรคำ
            </div>
            <div>
                <?php echo $timespent_today; ?>

            </div>
        </div>
    </div>

    <?php foreach ($arr_deck as $deck) {?>

        <div class="box__body box__body--info">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <h5>ชุดบัตรคำ <?php echo $deck->course->course_code . "-" . $deck->deck_name; ?></h5>
                    </div>
                    <div>
                        <?php if ($if_user_view_own_profile === true) {?>
                            <a href="<?php echo base_url(["Deck", "show", $deck->deck_id]); ?>" class="btn btn-primary">ไป</a>
                        <?php }?>
                    </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำที่ทำได้/ทั้งหมด
                </div>
                <div>
                    <?php echo $deck->num_user_card . "/" . $deck->num_all_card; ?>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำรอทบทวนวันนี้/พรุ่งนี้
                </div>
                <div>
                    <strong><?php echo $deck->card_to_review_today . "/" . $deck->card_to_review_tomorrow; ?></strong>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    ช่วงเวลาเฉลี่ยของชุดบัตรคำ
                </div>
                <div>
                    <strong><?php echo $deck->average_card_interval; ?> วัน</strong>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    รวมเวลาที่ทำ
                </div>
                <div>
                    <?php echo $deck->timespent; ?>
                </div>
            </div>

        </div>

    <?php }?>

    <div class="box__body box__body--warning">

        <div class="two_flex_column">
            <div>
                <h5>ดูบัตรคำทั้งหมดของ <?php if ($if_user_view_own_profile === true) {echo "ฉัน";} else {echo $member->displayname;}?></h5>
            </div>
            <div>
                <a href="<?php echo base_url(["Deck", "myDeck", $member->user_id]); ?>" class="btn btn-primary">ไป</a>
            </div>
        </div>

    </div>

    <div class="box__head box__head--info">
        ผู้ใช้ที่เกี่ยวข้องกับ <?php if ($if_user_view_own_profile === true) {echo "ฉัน";} else {echo $member->displayname;}?>
    </div>

    <?php foreach ($arr_user_to_show as $row_of_user) {?>

        <div class="row4icon">

            <?php foreach ($row_of_user as $user) {?>

                <div class="row4icon_icon">
                        <a href="<?php echo base_url(["User", "myProfile", $user->user_id]); ?>">
                            <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top"
                            src="<?php echo $user->avarta_url; ?>">
                        </a>
                </div>

            <?php }?>
        </div>

    <?php }?>

    <div class="box__body box__body--warning">

        <div class="two_flex_column">
            <div>
                <h5>ดูผู้ที่เกี่ยวข้องกับ  <?php if ($if_user_view_own_profile === true) {echo "ฉัน";} else {echo $member->displayname;}?> ทั้งหมด</h5>
            </div>
            <div>
                <a href="<?php echo base_url(["Follow", "myFollow", $member->user_id]); ?>" class="btn btn-primary">ไป</a>
            </div>
        </div>

    </div>
</div>
