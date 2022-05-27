
<div class="box">
     <div class="box__head box__head--info">
        ส่งออกบัตรคำ
    </div>

    <?php foreach( $arr_cardgroup as $cardgroup){ ?>

        <div class="box__body box__body--info">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>กลุ่มบัตรคำ :: <?php echo $cardgroup->cardgroup_id;?><br>
                        วิชา:: <?php echo $cardgroup->course->course_code." ".$cardgroup->course->course_name;?><br>
                        ชุดบัตรคำ :: <strong><?php echo $cardgroup->txt_deck;?></strong><br>
                        จำนวน :: <?php echo $cardgroup->num_card;?>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Admin","exportCardgroup","card",$cardgroup->cardgroup_id]);?>" class="btn btn-primary">Export</a>
                        
                    </div>
            </div>
             
        </div>

    <?php } ?>

</div>