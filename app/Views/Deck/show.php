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

                <a href="<?php echo base_url(["Card","show","a",$next_card_id,$deck->deck_id]);?>" 
                class="btn btn-primary  <?php if( $next_card_id === false){ echo "disabled";} ?> ">
                    ไป
                </a>

            </div>
        </div>
    </div>

    <div class="card-info card-info_body">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูบัตรคำทั้งหมด
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","showAllCard",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>
    
    <div class="card-info card-info_body">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูความคิดเห็นทั้งหมด
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","showAllComment",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>    


    <?php if( $num_user_card > 0  ){ ?>

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
                    ช่วงเวลา
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
                    <?php echo $sum_visit_time;?> ครั้ง
                </div>
            </div>
            
        </div>

    <?php } ?>

    <div class="card-info card-info_header">
        ผู้ใช้ล่าสุด
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

</div>

<?php if( $num_user_card > 0  ){ ?>

    <div class="card-info">
        <div class="card-info card-info_header">ส่วนจัดการบัตรคำ</div>
    </div>
    <div class="card-warning">
        <div class="card-warning card-warning_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    ล้างบัตรคำ :: <strong> <?php echo $num_user_card."/".$num_all_card;?> </strong>
                </div>
                <div>
                    <a href="<?php echo base_url(["Deck","clearAllCard",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
            </div>

        </div>
    </div>

<?php } ?>


