<div class="card-info">

    <div class="card-info card-info_header">
        สถิติประจำวัน
    </div>

    <div class="card-info card-info_body">
            <div class="two_flex_column">
                    <div>
                        <strong>วันนี้</strong>
                    </div>
                    <div style="text-align:right">
                         <?php echo $today_statistic_text;?>
                    </div>
             </div>
    </div>    

    <div class="card-info card-info_header">
        สถิติย้อนหลัง 15 วัน
    </div>

    <?php foreach( $arr_statistic as $statistic){ ?>

        <div class="card-info card-info_body">
            <div class="two_flex_column">
                    <div>
                        <strong><?php echo $statistic->thai_date;?></strong>
                    </div>
                    <div style="text-align:right">
                        <?php echo $statistic->statistic_text;?>
                    </div>
                </div>
        </div>

    <?php } ?>        

</div>