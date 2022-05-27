<div class="box">

    <div class="box__body box__body--warning">

        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url(["Admin","importTable"]);?>" class="btn btn-danger">Import</a>                
            </div>
            <div>
                <strong>นำเข้าตาราง</strong>
            </div>
        </div>

    </div>

    <?php foreach( $arr_table as $table ){ ?>

        <div class="box__body box__body--info">
            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <strong><?php echo $table->name;?></strong><br>
                        จำนวน :: <?php echo $table->num_row;?>
                    </div>
                    <div>

                        <a href="<?php echo base_url(["Admin","exportTable",$table->name,0]) ;?>" 
                        class="btn btn-primary">Export</a>

                    </div>
            </div>
        </div>

    <?php } ?>
    
</div>