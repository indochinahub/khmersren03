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

        <div class="two_flex_column" style="margin:10px">
            <div>
                <a href="<?php echo base_url( ["Post","showBy","Category", $postcategory->postcategory_id] );?>">
                    <strong>#<?php echo $postcategory->postcategory_title;?></strong>
                </a>
                [ <?php echo $postcategory_num_card;?> ]
            </div>
            <div>
                <a href="<?php echo $back_link;?>" class="btn btn-sm btn-primary">กลับ</a>
            </div>
        </div>
        
    </div>

</div>