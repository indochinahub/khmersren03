<div class="box">

    <div class="box__body box__body--info">

        <div>
            <h5><?php echo $lesson->lesson_title;?></h5>
            <h6 style="margin-top:5px">
                [ <?php echo $lesson->lesson_edittime;?> ]
            </h6>
        </div>

        <?php if( $lesson->lesson_content ){ ?>
        
            <div style="margin-bottom:15px">
                <?php echo $lesson->lesson_content;?>
            </div>
            
        <?php } ?>        

        <div class="two_flex_column">
            <div>
                กลับไปวิชา <a href="<?php echo base_url(["Course","show",$course->course_id]);?>">
                    <strong><?php echo $course->course_code." :: ".$course->course_name;?></strong>
                </a>
            </div>
            <div>
                <a href="<?php echo base_url(["Course","show",$course->course_id]);?>" class="btn btn-primary">กลับ</a>
            </div>
        </div>
        
    </div>

</div>

<?php if( $if_user_is_admin === true ){ ?>

    <div class="box">
        <div class="box__head box__head--info">
            จัดการบทความ
        </div>

        <div class="box__body box__body--warning">

                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url( ["Lesson","addEdit", "edit", $lesson->lesson_id] );?>" class="btn btn-primary">ทำ</a>
                    </div>
                    <div>
                        <strong>แก้ไข</strong>บทความนี้
                    </div>
                </div>

                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url( ["Lesson","delete",$lesson->lesson_id] );?>" class="btn btn-primary">ทำ</a>
                    </div>
                    <div>
                        <strong>ลบ</strong>บทความนี้
                    </div>
                </div>

        </div>

    </div>

<?php } ?>
