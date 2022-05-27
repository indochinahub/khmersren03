<?php echo $pagination_link;?>

<?php foreach( $arr_card as $card ){ ?>

    <div class="box">
        <div class="box__body box__body--danger">
            <h5>บัตรคำหมายเลข <?php echo $card->card_sort;?></h5>
        </div>

        <div class="box__head box__head--info">
            คำสั่ง
        </div>
        <div class="box__body box__body--info">

            <?php   foreach( $card->arr_command as $key => $command ){ 
                        if( $command && $key === 0 ){ 
                            echo "<strong>$command->html</strong>";
                        }elseif( $command ){
                            echo "<br>".$command->html;
                        }  
                    }
            ?>

        </div>

        <div class="box__head box__head--info">
            ตัวเลือก
        </div>

            <?php foreach( $card->arr_choice as $choice ){ ?>
                <?php if( $choice->a ){ ?>
                    <div class="box__body box__body--info">
                        <?php if($choice->a){ echo $choice->a->html;}?>
                        <?php if($choice->b){ echo "<br>".$choice->b->html;}?>
                        <?php if($choice->c){ echo "<br>".$choice->c->html;}?>
                        <?php if($choice->d){ echo "<br>".$choice->d->html;}?>
                    </div>    
                <?php } ?>
            <?php }?>

        <?php if( $card->arr_answer[0] || $card->arr_answer[1] || $card->arr_answer[2] ){ ?>
            <div class="box__head box__head--info">
                คำตอบ
            </div>
            <div class="box__body box__body--info">

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