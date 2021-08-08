<div class="card-info">
    <div class="card-info card-info_body">

        <form role="form" method="post">
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <textarea class="form-control" name="post_title" rows="1"><?php if($post->post_title){echo $post->post_title;}?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>คำนำ</strong> :: </label>
                <textarea class="form-control" name="post_intro" rows="4"><?php if($post->post_intro){echo $post->post_intro;};?></textarea>
           </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>เนื่อหา</strong> :: </label>
                <textarea class="form-control" name="post_content" rows="5"><?php if($post->post_content){echo $post->post_content;};?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>การจัดเรียง</strong> :: </label>
                <input type="text" class="form-control" name="post_sort" value="<?php if($post->post_sort){echo $post->post_sort;}?>">
            </div>
                        
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>กลุ่มบทความ</strong> :: </label>

                    <?php foreach( $arr_postcategory as $postcategory){ ?>

                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="<?php echo $postcategory->postcategory_id;?>" 
                                        name="id_postcategory" value="<?php echo $postcategory->postcategory_id;?>" 
                                        <?php echo $postcategory->checked_text;?>
                            >
                            <label for="<?php echo $postcategory->postcategory_id;?>" class="custom-control-label"><?php echo $postcategory->postcategory_title;?></label>
                        </div>                

                    <?php } ?>

                </div>
 
            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" class="btn btn-sm btn-primary">ปรับปรุง</button>
                </div>
            </div>

        </form>    




    </div>
</div>