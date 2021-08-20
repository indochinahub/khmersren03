<?php if( $user && ( $if_user_view_own_profile === false ) ){ ?>

    <div class="card-info">

        <div class="card-info card-info_body">
            <?php if( $relation_text === "we_folow_each_other"){ ?>
                <strong> xxx และฉันติดตามซึ่งกันและกัน</strong><br>
            <?php }elseif( $relation_text === "i_folow_the_other" ){ ?>        
                <strong> ฉันเป็นผู้ติดตามของ xxx</strong><br>
            <?php }elseif( $relation_text === "the_other_follow_me" ){ ?>        
                <strong> xxx เป็นผู้ติดตามแัน</strong><br>
            <?php }elseif( $relation_text === "we_have_no_relation" ){ ?>        
                <strong> ฉันและ xxx ไม่มีความสัมพันธ์กัน</strong><br>
            <?php } ?>                    
        </div>

        <?php if( ($relation_text === "we_folow_each_other") or ( $relation_text === "i_folow_the_other") ) { ?>

            <div class="card-info card-info_body">
                <div class="two_flex_column">
                    <div>
                        <strong>เลิกติดตาม</strong> xxxx
                    </div>
                    <div>
                        <a href="" class="btn btn-primary">เลิก</a>
                    </div>
                </div>
            </div>

        <?php }elseif( ($relation_text === "the_other_follow_me") or ( $relation_text === "we_have_no_relation") ) { ?>

            <div class="card-info card-info_body">
                <div class="two_flex_column">
                    <div>
                        <strong>ติดตาม</strong> xxxx
                    </div>
                    <div>
                        <a href="" class="btn btn-primary">เลิก</a>
                    </div>
                </div>
            </div>
            
        <?php } ?>


        <div class="card-info card-info_body">
            <div class="two_flex_column">
                <div>
                    <strong>ข้อความส่วนตัว</div>
                <div>
                    <a href="" class="btn btn-primary">เลิก</a>
                </div>
            </div>
        </div>    
    </div>

<?php } ?>    

<div class="card-info">
    <div class="card-info card-info_header">
        บัตรคำของ <?php if( $if_user_view_own_profile === true ){ echo "ฉัน"; }else{ echo $member->displayname; }?>
    </div>
</div>

<div class="card-warning">

    <div class="card-warning card-warning_body">


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
                <?php echo $total_num_user_card."/".$total_num_all_card;?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนวันที่เข้าใช้งาน/จำนวนวันจากวันแรก
            </div>
            <div>
                <?php echo $num_day_of_statistic."/".$num_day_from_start;?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาทั้งหมดที่ทำบัตรคำ
            </div>
            <div>
                <?php echo $total_timespent_of_user;?>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่เข้าสู่ระบบล่าสุด
            </div>
            <div>
                <?php echo $last_visit_time;?>
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
                <?php echo $num_visit_last_15_day."/15";?> วัน 
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                ร้อยละวันที่เข้าสู่ระบบ   
            </div>
            <div>
                <?php echo $percent_of_visit_last_15_day;?>%
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนเฉลี่ยบัตรคำที่ทำได้ต่อวัน   
            </div>
            <div>
                <?php echo $num_card_per_day_last_15_day;?> ข้อ/วัน
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาเฉลี่ยที่ใช้ทำบัตรคำต่อวัน    
            </div>
            <div>
                <?php echo $timespent_per_day_last_15_day;?>/วัน
            </div>
        </div>    
        <div class="two_flex_column">
            <div style="margin-bottom:5px;">
                <h5>สถิติวันนี้ <?php echo $today_date;?></h5>
            </div>
            <div>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                บัตรคำรอทบทวน      
            </div>
            <div>
                <?php echo $total_card_to_review_today."/".$total_card_to_review_tomorrow;?>
            </div>
        </div>       
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนบัตรคำที่ทำได้ 
            </div>
            <div>
                <?php echo $num_practice_have_done_today;?>
            </div>
        </div>       
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่ใช้ทำบัตรคำ  
            </div>
            <div>
                <?php echo $timespent_today;?> วินาที

            </div>
        </div>        
    </div>
</div>

<div class="card-info">    
    <?php foreach( $arr_deck as $deck ){ ?>
    
        <div class="card-info card-info_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <h5>ชุดบัตรคำ <?php echo $deck->course->course_code."-".$deck->deck_name;?></h5>
                    </div>
                    <div>
                        <?php if( $if_user_view_own_profile === true ){ ?>
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

<div class="card-warning">
    <div class="card-warning card-warning_body">
        
        <div class="two_flex_column">
            <div>
                <h5>ดูบัตรคำทั้งหมดของ <?php if( $if_user_view_own_profile === true ){ echo "ฉัน"; }else{ echo $member->displayname; }?></h5>
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","myDeck", $member->user_id]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>

    </div>
</div>

<div class="card-info">

    <div class="card-info card-info_header">
        บทความของ <?php if( $if_user_view_own_profile === true ){ echo "ฉัน"; }else{ echo $member->displayname; }?>
    </div>

    <?php foreach( $arr_post as $post ){ ?>

        <div class="card-info card-info_body">

            <div>
                <h5><a href="<?php echo base_url([ "Post","show",$post->post_id ]);?>"><?php echo $post->post_title;?></a></h5>
                <h6 style="margin-top:5px">
                    [ <?php echo $post->post_createddate;?>
                        โดย 
                        <a href="<?php echo base_url( ["User","myProfile", $post->user->user_id]);?>">
                            <?php echo $post->user->displayname;?>
                        </a>]
                </h6>
            </div>

            <div style="margin-bottom:15px">
                <?php echo $post->post_intro;?>
                    
            </div>

            <div class="two_flex_column">
                <div>
                    <a href="<?php echo base_url( ["Post","showBy","Category", $post->postcategory->postcategory_id] );?>">
                        <strong>#<?php echo $post->postcategory->postcategory_title;?></strong>
                    </a>
                    [ <?php echo $post->postcategory_num_card;?> ]
                </div>
                <div>
                    <a href="<?php echo base_url([ "Post","show",$post->post_id ]);?>" class="btn btn-primary">อ่าน</a>
                </div>
            </div>
            
        </div>

        <?php } ?>
</div>

<div class="card-warning">
    <div class="card-warning card-warning_body">
        
        <div class="two_flex_column">
            <div>
                <h5>ดูบทความทั้งหมดของ <?php if( $if_user_view_own_profile === true ){ echo "ฉัน"; }else{ echo $member->displayname; }?></h5>
            </div>
            <div>
                <a href="<?php echo base_url(["Post","showBy","User", $member->user_id]);?>" class="btn btn-primary">ไป</a>
                
            </div>
        </div>

    </div>
</div>

<div class="card-info">
    <div class="card-info card-info_header">
        กลุ่มบทความของ <?php if( $if_user_view_own_profile === true ){ echo "ฉัน"; }else{ echo $member->displayname; }?>
    </div>
    
    <?php foreach( $arr_postcategory as $postcategory){ ?>

        <div class="card-info card-info_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    #<?php echo $postcategory->postcategory_title;?>
                    [<?php echo $postcategory->num_post;?>]
                </div>
                <div>
                    <a href="<?php echo base_url(["Post","showBy","Category", $postcategory->postcategory_id]);?>" class="btn btn-primary">ไป</a>
                </div>
            </div>

        </div>

    <?php } ?>

</div>

