<div class="card-info">

    <?php foreach( $arr_cardgroup as $cardgroup){ ?>

        <div class="card-info card-info_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>กลุ่มบัตรคำ :: <?php echo $cardgroup->cardgroup_id;?><br>
                        วิชา:: <?php echo $cardgroup->course->course_code." ".$cardgroup->course->course_name;?><br>
                        ชุดบัตรคำ :: <strong><?php echo $cardgroup->txt_deck;?></strong><br>
                        จำนวน :: <?php echo $cardgroup->num_card;?>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Admin", "exportCardgroup", $cardgroup->cardgroup_id]);?>" class="btn btn-primary">Export</a>
                        
                    </div>
            </div>

        </div>

    <?php } ?>

</div>