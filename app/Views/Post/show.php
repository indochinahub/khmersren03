<div class="box">

    <div class="box__body box__body--info">

        <div>
            <h5><?php echo $post->post_title;?></h5>
            <h6 style="margin-top:5px">
                [ <?php echo $post->post_createtime;?>
                    โดย 
                    <a href="<?php echo base_url( ["User","myProfile", $owner->user_id]);?>">
                        <?php echo $owner->displayname;?>
                    </a>]
            </h6>
        </div>

        <div style="margin-bottom:15px">
            <?php echo $post->post_intro;?>
        </div>

        <?php if( $post->post_intro ){ ?>
        
            <div style="margin-bottom:15px">
                <?php echo $post->post_content;?>
            </div>
            
        <?php } ?>        

        <div class="two_flex_column">
            <div>
                <a href="<?php echo base_url( ["Post","showBy","Category", $postcategory->postcategory_id] );?>">
                    <strong>#<?php echo $postcategory->postcategory_title;?></strong>
                </a>
                [ <?php echo $postcategory_num_card;?> ]
            </div>
            <div>
                <a href="<?php echo $back_link;?>" class="btn btn-primary">กลับ</a>
            </div>
        </div>
        
    </div>

</div>



<?php if(  ( $editable === true) || ($deleteable === true) ){ ?>

    <div class="box">
        <div class="box__head box__head--info">
            จัดการบทความ
        </div>

        <div class="box__body box__body--info">

            <?php if(  ( $editable === true)){ ?>
                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url( ["Post","addEdit", "edit", $post->post_id] );?>" class="btn btn-primary">ทำ</a>
                    </div>
                    <div>
                        <strong>แก้ไข</strong>บทความนี้
                    </div>
                </div>
            <?php } ?>

            <?php if(  ( $deleteable === true)){ ?>            

                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url( ["Post","delete",$post->post_id] );?>" class="btn btn-primary">ทำ</a>
                    </div>
                    <div>
                        <strong>ลบ</strong>บทความนี้
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>

<?php } ?>    