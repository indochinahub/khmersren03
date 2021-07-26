<?php echo $pagination_link;?>

<div class="card-info">

    <?php foreach( $arr_cardcomment as $cardcomment){ ?>
        
        <div class="card-info card-info_body">
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
                        <a href="#" class="btn btn-primary">ไป</a>
                    </div>
                </div>
        </div>

    <?php } ?>

</div>