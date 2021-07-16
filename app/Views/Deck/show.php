<div class="card-info">
    <div class="card-info card-info_header">
        คำอธิบาย
    </div>
    <div class="card-info card-info_body">
            คำอธิบาย
    </div>
    <div class="card-info card-info_header">
        การใช้งานบัตรคำ
    </div>

    <div class="card-info card-info_body">
        <div style="display:flex;justify-content:space-between;">
            <div><strong>เพิ่ม/ทบทวนบัตรคำ</strong>
            </div>
            <div>
                <a href="<?php echo base_url(["Card","show","a",$next_card_id,$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>

    <div class="card-info card-info_body">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูบัตรคำทั้งหมด
            </div>
            <div>
                <a href="#" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>
    
    <div class="card-info card-info_body">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูความคิดเห็นทั้งหมด
            </div>
            <div>
                <a href="#" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>    

    <div class="card-info card-info_header">
        สถิติ
    </div>
    <div class="card-info card-info_body">
    
        <div class="two_flex_column">
            <div>
                จำนวนบัตรคำ    
            </div>
            <div>
                <?php echo $num_user_card."/".$num_all_card;?>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                <strong>บัตรคำรอทบทวนวันนี้/พรุ่งนี้</strong>
            </div>
            <div>
                <strong><?php echo $card_to_review_today."/".$card_to_review_tomorrow;?></strong>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                ระยะเวลาเฉลี่ย 
            </div>
            <div>
                <?php echo $avarage_card_interval;?> วัน
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                จำนวนครั้งที่เข้าเยี่ยมชม
            </div>
            <div>
                11508 ครั้ง
            </div>
        </div>
        
    </div>



</div>