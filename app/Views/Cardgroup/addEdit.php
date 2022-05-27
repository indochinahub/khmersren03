<div class="box">
    <div class="box__body box__body--info">

        <form role="form" method="post">

            <?php if(  $cardgroup_id ){ ?>
                <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                    <label><strong>Id</strong> :: </label>
                    <input type="text" class="form-control" name="cardgroup_id" value="<?php echo $cardgroup_id;?>" readonly>
                </div>
            <?php } ?>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Name</strong> :: </label>
                <input type="text" class="form-control" name="cardgroup_name" value="<?php echo $cardgroup_name;?>">
                <?php if( isset($cardgroup_name_error) && $cardgroup_name_error != "" ){ ?>
                    <div class="form-error">[<?php echo $cardgroup_name_error;?>]</div>
                <?php } ?>

            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Description</strong> :: </label>
                <textarea class="form-control" name="cardgroup_description" rows="3"><?php echo $cardgroup_description;?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 15px 0">
                <label><strong>Course</strong> :: </label>
                <select class="custom-select" name="id_course">

                    <?php foreach( $arr_course as $course ){ ?>
                        <option value="<?php echo $course->course_id;?>"  <?php echo $course->selected_text;?> >
                        
                        <?php echo $course->course_id.":".$course->course_code."::".$course->course_name;?>
                        </option>
                    <?php } ?>

                </select>
            </div>            

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">ปรับปรุง</button>
                </div>
            </div>

        </form>    

    </div>
</div>