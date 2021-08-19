<div class="card-info">

    <?php foreach( $arr_table as $table ){ ?>

        <div class="card-info card-info_body">
            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        ตาราง <strong><?php echo $table;?></strong><br>
                    </div>
                    <div>
                        <a href="http://127.0.0.1/khmersren03/Admin/exportCardgroup/1" class="btn btn-primary">Export</a>
                    </div>
            </div>
        </div>

    <?php } ?>
    
</div>