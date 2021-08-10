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
                    <button type="submit" class="btn btn-primary">ปรับปรุง</button>
                </div>
            </div>

        </form>    

    </div>
</div>

<div class="card-info">

    <div class="card-info card-info_header">
        การจัดการรูปภาพ
    </div>

    <div class="card-info card-info_body">
        
        <?php foreach( $arr_picture as $picture ){ ?>

                <h5>รูปที่ <?php echo $picture->media_order;?></h5>
                <?php echo $picture->html;?>
                <div class="two_flex_column" style="margin-top:10px">
                    <div>
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Media","deletePicture","post", $post->post_id, $picture->media_order ]);?>" class="btn btn-primary">ลบ</a>
                    </div>
                </div>

        <?php } ?>

    </div>

    <div class="card-info card-info_body">

        <form action="<?php echo base_url(["Media","addPicture","post",$post->post_id, $first_vacant_picture]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
            <div class="form-group">
                <label for="exampleInputFile">เพิ่มรูปภาพที่ <?php echo $first_vacant_picture;?> :: </label>
                <input type="file" name="myfile" size="20">
                <input type="hidden" name="redirect_url" value="http://www.khmersren.com/index.php/Post/addEdit/edit/346">
            </div>       

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">เพิ่ม</button>
                </div>
            </div>
        </form>

    </div>    

</div>