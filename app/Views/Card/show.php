<div class="card-info">
    <div class="card-info card-info_header">
        คำสั่ง
    </div>
    <div class="card-info card-info_body">
        <strong><?php echo $arr_command[0];?></strong>
            <?php if($arr_command[1]){ echo "<br>".$arr_command[1];}?>
            <?php if($arr_command[2]){ echo "<br>".$arr_command[2];}?>
            <?php if($arr_command[3]){ echo "<br>".$arr_command[3];}?>
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

            <div class="card-info card-info_body" style="<?php if($page === "b"){echo $style;}?>">
                <div>
                    <?php if($choice->a){ echo $choice->a;}?>
                    <?php if($choice->b){ echo "<br>".$choice->b;}?>
                    <?php if($choice->c){ echo "<br>".$choice->c;}?>
                    <?php if($choice->d){ echo "<br>".$choice->d;}?>
                </div>
                <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <?php if( $page === "a" ){ ?>
                            <a href="<?php echo base_url(array_merge( ["Card","show","b",$card->card_id, $deck->deck_id], $key_of_choices,[$choice->key]));?>" class="btn btn-primary">เลือก</a>
                        <?php } ?>
                    </div>
                </div>        
            </div>
        <?php } ?>

    <?php } ?>
<div>


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
                    <a href="<?php echo base_url(["Card","show","a", $next_card_id, $deck->deck_id]);?>" class="btn btn-primary">ไป</a>
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
                2061/2061            </div>
        </div>

        <div class="two_flex_column">
            <div>
                <strong>บัตรคำรอทบทวนวันนี้/พรุ่งนี้</strong>
            </div>
            <div>
                <strong>26/37</strong>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                ระยะเวลาเฉลี่ย 
            </div>
            <div>
                592 วัน
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                จำนวนครั้งที่เข้าเยี่ยมชม
            </div>
            <div>
                11508 ครั้ง
            </div>
        </div>
        
    </div>



</div>