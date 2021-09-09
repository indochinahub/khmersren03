<div class="box">
    <div class="box__body box__body--info">

        <form role="form" method="post">

            <?php if( $course_id ){ ?>
                <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                    <label><strong>Id</strong> :: <?php echo $course_id;?></label>
                </div>
            <?php } ?>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Sort</strong> :: </label>
                <input type="text" class="form-control" name="course_sort" value="<?php echo $course_sort;?>">
                <?php if( isset($course_sort_error) && $course_sort_error != "" ){ ?>
                    <div class="form-error">[<?php echo $course_sort_error;?>]</div>
                <?php } ?>
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Code</strong> :: </label>
                <input type="text" class="form-control" name="course_code" value="<?php echo $course_code;?>">
                <?php if( isset($course_code_error) && $course_code_error != "" ){ ?>
                    <div class="form-error">[<?php echo $course_code_error;?>]</div>
                <?php } ?>                
           </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Shortname</strong> :: </label>
                <input type="text" class="form-control" name="course_shortname" value="<?php echo $course_shortname;?>">
                <?php if( isset($course_shortname_error) && $course_shortname_error != "" ){ ?>
                    <div class="form-error">[<?php echo $course_shortname_error;?>]</div>
                <?php } ?>                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Name</strong> :: </label>
                <input type="text" class="form-control" name="course_name" value="<?php echo $course_name;?>">
                <?php if( isset($course_name_error) && $course_name_error != "" ){ ?>
                    <div class="form-error">[<?php echo $course_name_error;?>]</div>
                <?php } ?>                                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Download</strong> :: </label>
                <textarea class="form-control" name="course_download" rows="3" placeholder="[null]"><?php echo $course_download;?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 15px 0">
                <label><strong>Coursetype</strong> :: </label>
                <select class="custom-select" name="id_coursetype">
                    <?php foreach( $arr_coursetype as $coursetype){ ?>
                        <option value="<?php echo $coursetype->coursetype_id;?>" <?php echo $coursetype->selected_text;?>>
                            <?php echo $coursetype->coursetype_name;?>
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
