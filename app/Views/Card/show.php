<div class="card-info">
    <div class="card-info card-info_header">
        คำสั่ง
    </div>
    <div class="card-info card-info_body">
        <strong><?php echo $arr_command[0];?></strong>
            <?php if($arr_command[1]){ echo "<br>".$arr_command[1];}?>
            <?php if($arr_command[2]){ echo "<br>".$arr_command[2];}?>
           <?php  if($arr_command[3]){ echo "<br>".$arr_command[3];}?>
    </div>

    <div class="card-info card-info_header">
        ตัวเลือก
    </div>

    <?php foreach( $arr_choice as $choice){ ?>

        <?php if( $choice->a !== false){ ?>

            <?php       if( $page === "b" && $choice->key === 0 ){
                            $style = "background-color:#edffe2;";
                        }elseif( $page === "b" &&  $choice->key === $selected_choice ){
                            $style = "background-color:#f7abb3";
                        }elseif( $page === "b" ){
                            $style = "";
                        }
            ?>
            
            <?php if( $choice->a ){  ?>

                <div class="card-info card-info_body" style="<?php if($page === "b"){echo $style;}?>">
                    <div>
                        <?php if($choice->a){ echo $choice->a;}?>
                        <?php if($choice->b){ echo "<br>".$choice->b;}?>
                        <?php if($choice->c){ echo "<br>".$choice->c;}?>
                        <?php if($choice->d){ echo "<br>".$choice->d;}?>
                    </div>

                    <?php if( $page === "a" ){ ?>
                        <div class="two_flex_column">
                            <div>
                            </div>
                            <div>
                                <a href="<?php echo base_url(array_merge( ["Card","show","b",$card->card_id, $deck->deck_id], $key_of_choices,[$choice->key]));?>" class="btn btn-primary">เลือก</a>
                            </div>
                        </div>        
                    <?php } ?>                    
                </div>

            <?php } ?>



        <?php } ?>

    <?php } ?>
<div>


<?php if( $arr_answer[0] || $arr_answer[1] || $arr_answer[2] ){ ?>
    <div class="accordion" id="accordionExample">
        <div class="card-warning">
            <div class="card-warning card-warning_header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-block text-center" type="button" data-toggle="collapse" 
                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                    style="color:white;font-size:1rem">
                        [ คลิ๊กเพื่อตรวจคำตอบ ]
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-warning card-warning_body">

                    <?php if($arr_answer[0]){ echo $arr_answer[0];}?>
                    <?php if($arr_answer[1]){ echo $arr_answer[1];}?>
                    <?php if($arr_answer[2]){ echo $arr_answer[2];}?>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if( $page === "b" && ($selected_choice === 0)){ ?>

    <div class="card-success">
        <div class="card-success card-success_header">
            ผล
        </div>
        <div class="card-success card-success_body">
            <div>คำตอบ<strrong>ถูกต้อง</strong></div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>

                    <?php if( $next_card_id === false ){ ?>
                        <a href="<?php echo base_url(["Deck","show",$deck->deck_id]);?>" class="btn btn-primary">ไปชุดบัตรคำ</a>
                    <?php }else{ ?>
                        <a href="<?php echo base_url(["Card","show","a", $next_card_id, $deck->deck_id]);?>" class="btn btn-primary">ไป</a>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>    

<?php }elseif( $page === "b" ){ ?>

    <div class="card-danger">
        <div class="card-danger card-danger_header">
            ผล
        </div>
        <div class="card-danger card-danger_body">
            <div>คำตอบ<strrong>ไม่ถูกต้อง</strong></div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>
                <a href="<?php echo base_url(["Card","show","a", $next_card_id, $deck->deck_id]);?>" class="btn btn-primary">ไป</a>
                </div>
            </div>
        </div>
    </div>    

<?php } ?>


    
<div class="card-info">

    <div class="card-info card-info_header">
        สถิติ
    </div>
        
    <div class="card-info card-info_body">
    
        <div class="two_flex_column">
            <div>
                จำนวนบัตรคำ    
            </div>
            <div>
                <?php echo $num_user_card."/".$num_all_card;?>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                <strong>บัตรคำรอทบทวนวันนี้/พรุ่งนี้</strong>
            </div>
            <div>
                <strong><?php echo $card_to_review_today."/".$card_to_review_tomorrow;?></strong>
            </div>
        </div>

        <?php if($practice){ ?>
            <div class="two_flex_column">
                <div>
                    ช่วงเวลา
                </div>
                <div>
                    <?php echo $card_interval;?> วัน
                </div>
            </div>

            <div class="two_flex_column">
                <div>
                    เวลาทบทวนครั้งถัดไป
                </div>
                <div>
                    <?php echo $next_visit_date;?>
                </div>
            </div>

            <?php if( $page === "b" ){ ?>

                <div class="two_flex_column">
                    <div>
                        เวลาที่ใช้
                    </div>
                    <div>
                        <?php echo $time_spent;?>
                    </div>
                </div>                

            <?php } ?>




        <?php } ?>

        
    </div>



</div>