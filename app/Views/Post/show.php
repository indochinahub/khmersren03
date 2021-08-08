<div class="card-info">

    <div class="card-info card-info_body">

        <div>
            <h5><?php echo $post->post_title;?></h5>
            <h6>
                [ <?php echo $post->post_createddate;?>
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



<?php if(  ( $editable === true) || ($deleteabble === true) ){ ?>

    <div class="card-info">
        <div class="card-info card-info_header">
            จัดการบทความ
        </div>
    </div>

    <div class="card-warning">
        <div class="card-warning card-warning_body">

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