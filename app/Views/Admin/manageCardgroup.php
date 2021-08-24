<div class="card-warning">
    <div class="card-warning card-warning_header">
        นำเข้าบัตรคำ
    </div>
    <div class="card-warning card-warning_body"> 
        <div class="two_flex_column" style="margin-bottom:5px;">
            <div><strong>นำเข้า</strong>กลุ่มบัตรคำ
            </div>
            <div>
                <a href="<?php echo base_url(["Admin","importCard"]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>
    </div>

<div class="card-info">
     <div class="card-info card-info_header">
        ส่งออกบัตรคำ
    </div>

    <?php foreach( $arr_cardgroup as $cardgroup){ ?>

        <div class="card-info card-info_body">

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