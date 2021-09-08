<div class="box">

    <div class="box__body box__body--warning">
        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url(["Cardgroup","addEdit","new"]);?>" class="btn btn-primary">New</a>
            </div>
            <div>
                <strong>เพิ่มชุดบัตรคำใหม่</strong>
            </div>
        </div>
    </div>
    
    <?php foreach( $arr_cardgroup as $cardgroup){ ?>
        <div class="box__body box__body--info">
            <div class="two_flex_column">
                    <div>
                        Id :: <?php echo $cardgroup->cardgroup_id;?><br>
                        <?php echo $cardgroup->cardgroup_name;?>
                    </div>
                    <div>
                        <div style="margin-bottom:5px">
                            <a href="<?php echo base_url(["Cardgroup","addEdit","edit",$cardgroup->cardgroup_id]);?>" class="btn btn-warning">Edit</a>
                        </div>
                        <div>
                            <a href="" class="btn btn-danger">Delete</a>    
                        </div>
                        
                    </div>
            </div>
        </div>
    <?php } ?>     

</div>