<div class="box">
    
    <?php foreach( $arr_coursetype as $coursetype){ ?>
        <div class="box__head box__head--info">
            <?php echo $coursetype->coursetype_name;?>
        </div>

        <?php foreach( $coursetype->arr_course_as_row as $row ){ ?>

            <div class="row2icon">
                <div class="row2icon_icon" style="background-color:black">
                    <div>
                        <a href="<?php echo base_Url(["Course","show", $row[0]->course_id]);?>">
                            <img src="<?php echo $row[0]->icon_url;?>" width="100%">
                        </a>
                    </div>
                    <div style="padding:5px">
                        <a href="<?php echo base_Url(["Course","show", $row[0]->course_id]);?>">
                            <strong><?php echo $row[0]->course_code;?></strong><br>
                            <?php echo $row[0]->course_name;?>
                        </a>
                    </div>
                </div>

                <?php if( $row[1] !== false ){ ?>
                    <div class="row2icon_icon" style="background-color:black">
                        <div>
                            <a href="<?php echo base_Url(["Course","show", $row[1]->course_id]);?>">
                                <img src="<?php echo $row[1]->icon_url;?>" width="100%">
                            </a>
                        </div>
                        <div style="padding:5px">
                            <a href="<?php echo base_Url(["Course","show", $row[1]->course_id]);?>">
                                <strong><?php echo $row[1]->course_code;?></strong><br>
                                <?php echo $row[1]->course_name;?>
                            </a>
                        </div>
                    </div>
                <?php }else{ ?>

                    <div class="row2icon_icon">
                    </div>

                <?php } ?>

            </div>

        <?php } ?>                
            

    <?php } ?>
    
</div>