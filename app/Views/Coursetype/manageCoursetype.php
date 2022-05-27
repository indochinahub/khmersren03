<div class="box">

    <div class="box__body box__body--warning">

        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url(["Coursetype","addEdit","new"]);?>" class="btn btn-primary">New</a>        
            </div>
            <div>
                <strong>เพิ่มกลุ่มวิชาใหม่</strong>
            </div>
        </div>

    </div>

    <?php foreach( $arr_coursetype as $coursetype){ ?>
        <div class="box__body box__body--info">
            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <?php echo $coursetype->coursetype_id;?> :: <strong><?php echo $coursetype->coursetype_name;?></strong>
                        <?php if( $coursetype->num_coure ){  echo "[".$coursetype->num_coure."]";}?>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Coursetype","addEdit","edit",$coursetype->coursetype_id]);?>" class="btn btn-warning">Edit</a>
                        <a href="<?php echo base_url(["Coursetype","delete",$coursetype->coursetype_id]);?>" class="btn btn-danger">Delete</a>
                    </div>
            </div>
        </div>
    <?php  }?>

        
</div>