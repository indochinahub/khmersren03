<div class="card-info">

<?php foreach( $arr_message as $message ){ ?>
    <div class="card-info card-info_body">
        <div class="two_flex_column">
            <div>
                <strong><?php echo $message->other_displayname;?></strong><br>
                <?php echo $message->thai_active_date;?>
            </div>
            <div style="margin-bottom:5px">
                <a href="<?php echo base_url(["Message","with",$message->other->user_id]);?>" class="btn btn-sm btn-primary">ไป
                </a>
            </div>
        </div>
    </div>
<?php } ?>    
</div>