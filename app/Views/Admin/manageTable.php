<div class="card-info">

    <?php foreach( $arr_table as $table ){ ?>

        <div class="card-info card-info_body">
            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <strong><?php echo $table->name;?></strong><br>
                        จำนวน :: <?php echo $table->num_row;?>
                    </div>
                    <div>

                        <a href="<?php echo base_url(["Admin","ImportTable",$table->name,0]) ;?>" 
                        class="btn btn-danger">Import</a>

                        <a href="<?php echo base_url(["Admin","exportTable",$table->name,0]) ;?>" 
                        class="btn btn-primary">Export</a>

                    </div>
            </div>
        </div>

    <?php } ?>
    
</div>