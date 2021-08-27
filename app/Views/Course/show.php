<div class="card-info">
    <div class="card-info card-info_header">
        คำอธิบาย
    </div>
    <div class="card-info card-info_body">
        <?php if($course->course_description){ ?>
            <?php echo $course->course_description;?>
        <?php }else{ ?>
            ยังไม่มีคำอธิบาย
        <?php } ?>
        
    </div>

    <?php if( $arr_deck && $user){ ?>
    
        <div class="card-info card-info_header">
            ชุดบัตรคำ
        </div>

        <?php foreach( $arr_deck as $deck){ ?>

            <div class="card-info card-info_body">
                <div style="display:flex;justify-content:space-between;">
                    <div>ชุดบัตรคำ ::<strong><?php echo $course->course_code."-".$deck->deck_name;?></strong><br>
                        จำนวนบัตรคำ :: <?php echo $deck->num_user_card."/".$deck->num_all_card;?><br>
                        บัตรคำรอทบทวนวันนี้/พรุ่งนี้ :: <?php echo $deck->card_to_review_today."/".$deck->card_to_review_tomorrow;?><br>
                        ระยะเวลาเฉลี่ย :: <?php echo $deck->avarage_card_interval;?><br>
                        
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Deck","show",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
                        
                    </div>
                </div>
            </div>
            
        <?php } ?>

    <?php } ?>        

    <?php if( $user && $arr_user_to_show ){ ?>

        <div class="card-info card-info_header">
            ผู้ที่เข้าใช้บัตรคำล่าสุด
        </div>
        <div class="card-info card-info_body">

        <?php foreach( $arr_user_to_show as $row_of_user ){ ?>
                
                <div style="display:flex;justify-content:space-evenly">
                                                    
                    <?php foreach( $row_of_user as $user ){ ?>

                        <?php if($user){ ?>
                            <div style="background-color:#becae6;width:24%">
                                    <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                        <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                        src="<?php echo $user->avarta_url;?>">
                                    </a><br>
                                    <?php echo $user->displayname;?>
                            </div>
                        <?php }else{ ?>
                            <div style="width:24%">
                            </div>                        
                        <?php } ?>                        

                    <?php } ?>
                </div>

            <?php } ?>  

        </div>

    <?php } ?>    

</div>

<?php if( $if_user_is_adamin === true){ ?>
    <div class="card-info">
            <div class="card-info card-info_header">
                จัดการบัตรคำ
            </div>
    </div>

    <div class="card-warning">

        <div class="card-warning card-warning_body">
            <div class="two_flex_column">
                <div>
                    แก้ไขบัตรคำ
                </div>
                <div>
                    <a href="http://127.0.0.1/khmersren03/Card/edit/9583/16" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>

        <div class="card-warning card-warning_body">
            <div class="two_flex_column">
                <div>
                    ลบบัตรคำ
                </div>
                <div>
                    <a href="http://127.0.0.1/khmersren03/Card/delete/9583/16" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>

    </div>
<?php }?>

<div class="card-info">
    <div class="card-info card-info_header">
        บทเรียน
    </div>
    
    <?php foreach( $arr_lesson as $lesson){ ?>
        <div class="card-info card-info_body">
            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    <?php echo $lesson->lesson_title;?>
                </div>
                <div>
                    <a href="<?php echo base_url(["Lesson","show",$lesson->lesson_id]);?>" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<div class="card-warning">
    <div class="card-warning card-warning_body">
        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url(["Lesson","addEdit","new",$course->course_id]);?>" class="btn btn-primary">ไป</a>
                    
            </div>
            <div>
                <strong>เพิ่ม</strong>บทเรียน
            </div>
        </div>
    </div>
</div>