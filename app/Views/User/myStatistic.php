<div class="box">

    <div class="box__head box__head--info">
        สถิติประจำวัน
    </div>

    <div class="box__body box__body--info">
            <div class="two_flex_column">
                    <div>
                        <strong>วันนี้</strong>
                    </div>
                    <div style="text-align:right">
                         <?php echo $today_statistic_text;?>
                    </div>
             </div>
    </div>    

    <div class="box__head box__head--info">
        สถิติย้อนหลัง 15 วัน
    </div>

    <?php foreach( $arr_statistic as $statistic){ ?>

        <div class="box__body box__body--info">
            <div class="two_flex_column">
                    <div>
                        <strong><?php echo $statistic->date;?></strong>
                    </div>
                    <div style="text-align:right">
                        <?php echo $statistic->statistic_text;?>
                    </div>
                </div>
        </div>

    <?php } ?>        

</div>