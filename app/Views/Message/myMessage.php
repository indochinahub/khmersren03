<div class="box">

    <?php foreach( $arr_message as $message ){ ?>
        <div class="box__body box__body--info">
            <div class="two_flex_column">
                <div>
                    <strong><?php echo $message->other_displayname;?></strong>
                    <?php if($message->num_unread > 0 ){ echo "[$message->num_unread]";}?><br>
                    <?php echo $message->thai_active_date;?>
                </div>
                <div style="margin-bottom:5px">
                    <a href="<?php echo base_url(["Message","with",$message->other->user_id]);?>" class="btn btn-primary">ไป
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>    

</div>