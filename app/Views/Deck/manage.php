<div class="box">

    <div class="box__body box__body--warning">
        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url( ["Deck","addEdit","new"]);?>" class="btn btn-primary">New</a>
            </div>
            <div>
                <strong>เพิ่มชุดบัตรคำใหม่</strong>
            </div>
        </div>
    </div>
    

    <?php foreach( $arr_deck as $deck){ ?>

        <div class="box__body box__body--info">
            <div class="two_flex_column">
                <div>
                    <strong><?php echo  $deck->course->course_code."-".$deck->deck_name;?></strong><br>
                    Course : <?php echo  $deck->course->course_name;?><br>
                    Sort : <?php echo $deck->deck_sort;?>

                </div>
                <div>
                    <div style="margin-bottom:5px">
                        <a href="<?php echo base_url( ["Deck","addEdit","edit",$deck->deck_id] );?>" class="btn btn-warning">Edit</a>
                    </div>
                    <div>
                        <a href="<?php echo base_url( ["Deck","delete",$deck->deck_id] );?>" class="btn btn-danger">Delete</a>    
                    </div>
                </div>
            </div>
        </div>
           
    <?php } ?>
</div>