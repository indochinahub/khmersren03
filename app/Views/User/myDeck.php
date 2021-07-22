<div class="card-info">
    <div class="card-info card-info_header">
        บัตรคำของฉัน
    </div>

    <?php foreach( $arr_deck as $deck ){ ?>
    
        <div class="card-info card-info_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <h5>ชุดบัตรคำ <?php echo $deck->course->course_code."-".$deck->deck_name;?></h5>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Deck","show", $deck->deck_id]);?>" class="btn btn-primary">ไป</a>
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