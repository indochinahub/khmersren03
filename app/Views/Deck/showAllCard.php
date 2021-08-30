<?php echo $pagination_link;?>

<?php foreach( $arr_card as $card ){ ?>

    <div class="card-danger">
        <div class="card-danger card-danger_body">
            <h5>บัตรคำหมายเลข <?php echo $card->card_sort;?></h5>
        </div>
    </div>

    <div class="card-info">

        <div class="card-info card-info_header">
            คำสั่ง
        </div>
        <div class="card-info card-info_body">

            <?php   foreach( $card->arr_command as $key => $command ){ 
                        if( $command && $key === 0 ){ 
                            echo "<strong>$command->html</strong>";
                        }elseif( $command ){
                            echo "<br>".$command->html;
                        }  
                    }
            ?>

        </div>

        <div class="card-info card-info_header">
            ตัวเลือก
        </div>

            <?php foreach( $card->arr_choice as $choice ){ ?>
                <?php if( $choice->a ){ ?>
                    <div class="card-info card-info_body">
                        <?php if($choice->a){ echo $choice->a->html;}?>
                        <?php if($choice->b){ echo "<br>".$choice->b->html;}?>
                        <?php if($choice->c){ echo "<br>".$choice->c->html;}?>
                        <?php if($choice->d){ echo "<br>".$choice->d->html;}?>
                    </div>    
                <?php } ?>
            <?php }?>

        <?php if( $card->arr_answer[0] || $card->arr_answer[1] || $card->arr_answer[2] ){ ?>
            <div class="card-info card-info_header">
                คำตอบ
            </div>
            <div class="card-info card-info_body">

                    <?php   foreach( $card->arr_answer as $key=>$answer ){ 
                                if( $answer && $key === 0 ){ 
                                    echo $answer->html;
                                }elseif( $answer ){
                                    echo "<br>".$answer->html;
                                }
                            } 
                    ?>                

            </div>
        <?php } ?>

    </div>
<?php } ?>