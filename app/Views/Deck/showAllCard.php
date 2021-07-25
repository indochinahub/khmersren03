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
            <strong><?php echo $card->arr_command[0];?></strong>
            <?php if($card->arr_command[1]){ echo "<br>".$card->arr_command[1];}?>
            <?php if($card->arr_command[2]){ echo "<br>".$card->arr_command[2];}?>
            <?php if($card->arr_command[3]){ echo "<br>".$card->arr_command[3];}?>
        </div>

        <div class="card-info card-info_header">
            ตัวเลือก
        </div>

            <?php foreach( $card->arr_choice as $choice ){ ?>
                <?php if( $choice->a ){ ?>
                    <div class="card-info card-info_body">
                        <?php if($choice->a){ echo $choice->a;}?>
                        <?php if($choice->b){ echo "<br>".$choice->b;}?>
                        <?php if($choice->c){ echo "<br>".$choice->c;}?>
                        <?php if($choice->d){ echo "<br>".$choice->d;}?>
                    </div>    
                <?php } ?>
            <?php }?>

        <?php if( $card->arr_answer[0] || $card->arr_answer[1] || $card->arr_answer[2] ){ ?>
            <div class="card-info card-info_header">
                คำตอบ
            </div>
            <div class="card-info card-info_body">
                <?php if($card->arr_answer[0]){ echo $card->arr_answer[0];}?>
                <?php if($card->arr_answer[1]){ echo $card->arr_answer[1];}?>
                <?php if($card->arr_answer[2]){ echo $card->arr_answer[2];}?>
            </div>
        <?php } ?>

    </div>
<?php } ?>