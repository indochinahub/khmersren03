<div class="card-info">

    <div class="card-info card-info_body">

        <div>
            <h5><a href="<?php echo base_url([ "Post","show",$post->post_id ]);?>"><?php echo $post->post_title;?></a></h5>
            <h6>
                [ <?php echo $post->post_createddate;?>
                    โดย 
                    <a href="<?php echo base_url( ["Profile","member", $owner->user_id]);?>">
                        <?php echo $owner->displayname;?>
                    </a>]
            </h6>
        </div>

        <div style="margin-bottom:15px">

            <?php echo $post->post_intro;?>
                
        </div>
        <div style="margin-bottom:15px">

            <?php echo $post->post_content;?>
                
        </div>

        <div class="two_flex_column" style="margin:10px">
            <div>
                <a href="#">
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