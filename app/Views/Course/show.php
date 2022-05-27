<div class="box">
    <div class="box__head box__head--info">
        คำอธิบาย
    </div>
    <div class="box__body box__body--info">
        <?php if($course->course_description){ ?>
            <?php echo $course->course_description;?>
        <?php }else{ ?>
            ยังไม่มีคำอธิบาย
        <?php } ?>
        
    </div>

    <?php if($course->course_download ){ ?>
        <div class="box__head box__head--info">
            เอกสารสำหรับดาวน์โหลด
        </div>
        <div class="box__body box__body--info">
            <?php echo $course->course_download;?>
        </div>    
    <?php } ?>        

    <?php if( $arr_deck && $user){ ?>
    
        <div class="box__head box__head--info">
            ชุดบัตรคำ
        </div>

        <?php foreach( $arr_deck as $deck){ ?>

            <div class="box__body box__body--info">
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

        <div class="box__head box__head--info">
            ผู้ที่เข้าใช้บัตรคำล่าสุด
        </div>

        <?php foreach( $arr_user_to_show as $row_of_user ){ ?>
                
                <div class="row4icon">
                                                    
                    <?php foreach( $row_of_user as $user ){ ?>

                        <?php if($user){ ?>
                            <div class="row4icon_icon">
                                    <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                        <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                        src="<?php echo $user->avarta_url;?>">
                                    </a>
                            </div>
                        <?php }else{ ?>
                            <div class="row4icon_icon">
                            </div>                        
                        <?php } ?>                        

                    <?php } ?>
                </div>

            <?php } ?>  

    <?php } ?>    

</div>

<div class="box">

    <div class="box__head box__head--info">
        บทเรียน
    </div>

    <?php foreach( $arr_lesson_to_show as $row_of_lesson ){ ?>

        <div class="row3icon">


            <?php foreach( $row_of_lesson as $lesson ){ ?>
            
                <?php if($lesson){ ?>
                
                    <div class="row3icon_icon">
                        <a href="<?php echo base_url(["Lesson","show",$lesson->lesson_id]);?>"> 
                            <div>
                                <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                    src="<?php echo $lesson->thumnail_url;?>">

                            </div>
                            <div style="padding:5px">
                                <?php echo $lesson->lesson_title;?>
                            </div>
                        </a>                        
                    </div>

                <?php }else{ ?>
                    <div class="row3icon_icon">
                    </div>
                <?php } ?>

            <?php }?>                                    

        </div>

    <?php } ?>

    <div class="box__body box__body--warning">
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