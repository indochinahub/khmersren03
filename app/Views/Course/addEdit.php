<div class="card-info">
    <div class="card-info card-info_body">

        <form role="form" method="post">

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Id</strong> :: <?php echo $course->course_id;?></label>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Sort</strong> :: </label>
                <input type="text" class="form-control" name="course_sort" value="<?php if($course->course_sort){echo $course->course_sort;}?>"
                    placeholder="[null]"
                >
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Code</strong> :: </label>
                <input type="text" class="form-control" name="course_code" value="<?php if($course->course_code){echo $course->course_code;};?>">
           </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Shortname</strong> :: </label>
                <input type="text" class="form-control" name="course_shortname" value="<?php if($course->course_shortname){echo $course->course_shortname;};?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Name</strong> :: </label>
                <input type="text" class="form-control" name="course_name" value="<?php if($course->course_name){echo $course->course_name;}?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Download</strong> :: </label>
                <textarea class="form-control" name="course_download" rows="3" placeholder="[null]"><?php if($course->course_download){echo $course->course_download;}?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 15px 0">
                <label><strong>Id Coursetype</strong> :: </label>
                <textarea class="form-control" name="id_coursetype" rows="1"><?php if($course->id_coursetype){echo $course->id_coursetype;}?></textarea>
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
