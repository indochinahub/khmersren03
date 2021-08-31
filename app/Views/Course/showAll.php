<div class="box">
    <div class="box__body box__body--info">
        
        <div class="two_flex_column">
            <div>
                <h5>เพิ่มวิชา</h5>
            </div>
            <div>
                <a href="<?php echo base_url(["Course","addEdit","new"]);?>" class="btn btn-primary">ไป</a>
            </div>
        </div>

    </div>

    <?php foreach( $arr_coursetype as $coursetype){ ?>
        <div class="box__head box__head--info">
            <?php echo $coursetype->coursetype_name;?>
        </div>

        <div class="box__body box__body--info">

            <?php foreach( $coursetype->arr_course_as_row as $row ){ ?>

                <div class="icon_row">
                    <div class="course_icon">
                        <div class="course_icon-thumbnail">
                            <a href="<?php echo base_Url(["Course","show", $row[0]->course_id]);?>">
                                <img src="<?php echo $row[0]->icon_url;?>" width="100%">
                            </a>
                        </div>
                        <div class="course_icon-title" style="">
                            <a href="<?php echo base_Url(["Course","show", $row[0]->course_id]);?>">
                                <strong><?php echo $row[0]->course_code;?></strong><br>
                                <?php echo $row[0]->course_name;?>
                            </a>
                        </div>		
                    </div>		
                    
                    <?php if( $row[1] !== false ){ ?>
                        <div class="course_icon">
                            <div class="course_icon-thumbnail">
                                <a href="<?php echo base_Url(["Course","show", $row[1]->course_id]);?>">
                                    <img src="<?php echo $row[1]->icon_url;?>" width="100%">
                                </a>
                            </div>
                            <div class="course_icon-title" style="">
                                <a href="<?php echo base_Url(["Course","show", $row[1]->course_id]);?>">
                                    <strong><?php echo $row[1]->course_code;?></strong><br>
                                    <?php echo $row[1]->course_name;?>
                                </a>
                            </div>		
                        </div>		
                    <?php }else{ ?>
                        <div>
                        </div>		                        
                        
                    <?php } ?>

                </div>

            <?php } ?>                
            
        </div>
    <?php } ?>
    
</div>