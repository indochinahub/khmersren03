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
                aaa/bbb
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาทั้งหมดที่ทำบัตรคำ
            </div>
            <div>
                ccc.cc ชั่วโมง
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่เข้าสู่ระบบล่าสุด
            </div>
            <div>
                13 ส.ค. 2564 14:20 น.
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
                11/15 วัน 
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                ร้อยละวันที่เข้าสู่ระบบ   
            </div>
            <div>
                73%
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนเฉลี่ยบัตรคำที่ทำได้ต่อวัน   
            </div>
            <div>
                18 ข้อ/วัน
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาเฉลี่ยที่ใช้ทำบัตรคำต่อวัน    
            </div>
            <div>
                6 นาที /วัน
            </div>
        </div>    
        <div class="two_flex_column">
            <div style="margin-bottom:5px;">
                <h5>สถิติวันนี้ 13 ส.ค. 2564</h5>
            </div>
            <div>
            </div>
        </div>
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                บัตรคำรอทบทวน      
            </div>
            <div>
                65/67
            </div>
        </div>       
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                จำนวนบัตรคำที่ทำได้ 
            </div>
            <div>
                0
            </div>
        </div>       
        <div class="two_flex_column">
            <div style="padding:0 0 0 15px">
                เวลาที่ใช้ทำบัตรคำ  
            </div>
            <div>
                0 วินาที
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
                <h6>
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

