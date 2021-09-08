<div class="box">

    <div class="box__body box__body--warning">

        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="<?php echo base_url(["Course","addEdit","new"]);?>" class="btn btn-primary">New</a>    
            </div>
            <div>
                <strong>เพิ่มวิชาใหม่</strong>
            </div>
        </div>

    </div>

    <?php foreach( $arr_course as $course ){ ?>

        <div class="box__body box__body--info">
            <div class="two_flex_column">
                    <div>
                        <strong><?php echo $course->course_code;?></strong><br>
                        <?php echo $course->course_name;?>
                    </div>
                    <div>
                        <a href="<?php echo base_url( ["Course","addEdit","edit",$course->course_id]);?>" class="btn btn-warning">Edit</a>
                        <a href="<?php echo base_url( ["Course","delete",$course->course_id]);?>" class="btn btn-danger">Delete</a>
                    </div>
            </div>
        </div>

    <?php }?>        
</div>