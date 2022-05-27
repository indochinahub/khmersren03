<div class="box">
    <div class="box__head box__head--info">
        คำอธิบาย
    </div>
    <div class="box__body box__body--info">
            คำอธิบาย
    </div>
    <div class="box__head box__head--info">
        การใช้งานบัตรคำ
    </div>

    <div class="box__body box__body--info">
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

    <div class="box__body box__body--info">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูบัตรคำทั้งหมด
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","showAllCard",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>
    
    <div class="box__body box__body--info">
        <div style="display:flex;justify-content:space-between;">
            <div>ดูความคิดเห็นทั้งหมด
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","showAllComment",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>    


    <?php if( $num_user_card > 0  ){ ?>

        <div class="box__head box__head--info">
            สถิติ
        </div>
        <div class="box__body box__body--info">
        
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

    <div class="box__head box__head--info">
        ผู้ใช้ล่าสุด
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

    <?php if( $num_user_card > 0  ){ ?>

        <div class="box__head box__head--info">
            ส่วนจัดการบัตรคำ
        </div>

        <div class="box__body box__body--warning">

            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    ล้างบัตรคำ :: <strong> <?php echo $num_user_card."/".$num_all_card;?> </strong>
                </div>
                <div>
                    <a href="<?php echo base_url(["Deck","clearAllCard",$deck->deck_id]);?>" class="btn btn-primary">ไป</a>
            </div>
            </div>

        </div>
    
    <?php } ?>

</div>


