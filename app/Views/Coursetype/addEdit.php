<div class="box__body box__body--info">

        <form role="form" method="post">

            <?php if($coursetype_id){ ?>
                <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                    <label>CourseType Id :: <?php echo $coursetype_id;?></label>
                </div>
            <?php } ?>
            
            <div class="form-group">
                <label>CourseType Name ::</label>
                <input type="text" class="form-control" name="coursetype_name" value="<?php echo $coursetype_name;?>">
                <?php if( isset($coursetype_name_error) && $coursetype_name_error != "" ){ ?>
                    <div class="form-error">[<?php echo $coursetype_name_error;?>]</div>
                <?php } ?>
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