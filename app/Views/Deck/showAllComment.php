<?php echo $pagination_link;?>

<div class="box">

    <?php foreach( $arr_cardcomment as $cardcomment){ ?>
        
        <div class="box__body box__body--info">
            <div>
                <strong>ชุดบัตรคำ :: <?php echo $course->course_code."-".$deck->deck_name;?></strong><br>
                <strong>ลำดับ :: <?php echo $cardcomment->card->card_sort;?></strong><br>
                วิชาเรียน :: [ <?php echo $course->course_name;?> ]<br>
                โดย :: [ <strong><?php echo $cardcomment->user->display_name;?></strong> ] เมื่อ <?php echo $cardcomment->visited_time;?><br>
                <strong> โดย </strong> :: <?php echo nl2br($cardcomment->cardcomment_text);?>
                
            </div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <a href="<?php echo base_url(["Card","show","a",$cardcomment->id_card, $cardcomment->id_deck]);?>" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>

    <?php } ?>

</div>