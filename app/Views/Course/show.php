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

    <div class="card-info card-info_header">
        ชุดบัตรคำ
    </div>

    <?php foreach( $arr_deck as $deck){ ?>

        <div class="card-info card-info_body">
            <div style="display:flex;justify-content:space-between;">
                <div>ชุดบัตรคำ ::<strong><?php echo $course->course_code."-".$deck->deck_name;?></strong><br>
                    จำนวนบัตรคำ :: <?php echo $deck->num_user_card."/".$deck->num_all_card;?><br>
                    บัตรคำรอทบทวนวันนี้/พรุ่งนี้ :: <?php echo $deck->card_to_review_today."/".$deck->card_to_review_tomorrow;?><br>
                    ระยะเวลาเฉลี่ย :: iii<br>
                </div>
                <div>
                    <a href="<?php echo base_url(["Deck","show",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
                    
                </div>
            </div>
        </div>
        
    <?php } ?>



    <div class="card-info card-info_header">บทเรียน</div>
    <div class="card-info card-info_body">This is Body</div>

</div>



