<?php echo $pagination_link;?>

<?php if( ($groupBy === "User") && ($if_user_view_own_post === true) ){ ?>

    <div class="box">
        <div class="box__body box__body--warning">
                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url( ["Post","addEdit","new"]);?>" class="btn btn-primary">ไป</a>
                    </div>
                    <div>
                        <strong>เพิ่ม</strong>บทความ
                    </div>
                </div>
        </div>
    </div>

<?php } ?>    

<div class="box">

    <?php foreach( $arr_post as $post ){ ?>

        <div class="box__body box__body--info">

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
                    <a href="<?php echo base_url( ["Post","showBy","Category",$post->postcategory->postcategory_id] );?>">
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

<?php echo $pagination_link;?>
