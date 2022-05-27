<div class="box">
    <div class="box__head box__head--info">
        บัตรคำของ <?php if( $if_user_view_own_profile === true ){echo "ฉัน";}else{ echo $member->displayname;} ?>
    </div>

    <?php foreach( $arr_deck as $deck ){ ?>
    
        <div class="box__body box__body--info">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <h5>ชุดบัตรคำ <?php echo $deck->course->course_code."-".$deck->deck_name;?></h5>
                    </div>
                    <div>
                        <?php if( $if_user_view_own_profile === true){ ?>
                            <a href="<?php echo base_url(["Deck","show", $deck->deck_id]);?>" class="btn btn-primary">ไป</a>    
                        <?php } ?>                        
                    </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำที่ทำได้/ทั้งหมด                            
                </div>
                <div>
                    <?php echo $deck->num_user_card."/".$deck->num_all_card;?>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำรอทบทวนวันนี้/พรุ่งนี้
                </div>
                <div>
                    <strong><?php echo $deck->card_to_review_today."/".$deck->card_to_review_tomorrow;?></strong>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    ช่วงเวลาเฉลี่ยของชุดบัตรคำ
                </div>
                <div>
                    <strong><?php echo $deck->average_card_interval;?> วัน</strong>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    รวมเวลาที่ทำ
                </div>
                <div>
                    <?php echo $deck->timespent;?>
                </div>
            </div>

        </div>

    <?php } ?>
        
</div>
