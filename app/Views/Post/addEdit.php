<div class="box">
    <div class="box__body box__body--info">

        <form role="form" method="post">
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <input type="text" class="form-control" name="post_title" value="<?php echo $post_title;?>">
                <?php if( isset($post_title_error) && $post_title_error != "" ){ ?>
                    <div class="form-error">[<?php echo $post_title_error;?>]</div>
                <?php } ?>                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>คำนำ</strong> :: </label>
                <textarea class="form-control" name="post_intro" rows="4"><?php echo $post_intro;?></textarea>
                <?php if( isset($post_intro_error) && $post_intro_error != "" ){ ?>
                    <div class="form-error">[<?php echo $post_intro_error;?>]</div>
                <?php } ?>  
           </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>เนื่อหา</strong> :: </label>
                <textarea class="form-control" name="post_content" rows="5"><?php echo $post_content;?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>การจัดเรียง</strong> :: </label>
                <input type="text" class="form-control" name="post_sort" value="<?php echo $post_sort;?>">
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

<?php if( $display_media_part === true ){ ?>

    <div class="box">

        <div class="box__head box__head--info">
            การจัดการรูปภาพ
        </div>

        <?php if( $arr_picture ){ ?>
        
            <div class="box__body box__body--info">
                
                <?php foreach( $arr_picture as $picture ){ ?>

                        <h5>รูปที่ <?php echo $picture->media_order;?></h5>
                        <?php echo $picture->html;?>
                        <div class="two_flex_column" style="margin-top:10px">
                            <div>
                            </div>
                            <div>
                                <a href="<?php echo base_url(["Media","deletePicture","post", $post_id, $picture->media_order ]);?>" class="btn btn-warning">ลบ</a>
                            </div>
                        </div>

                <?php } ?>

            </div>

        <?php } ?>

        <?php if($first_vacant_picture){ ?>

            <div class="box__body box__body--info">

                <form action="<?php echo base_url(["Media","addPicture","post",$post_id, $first_vacant_picture]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
                    <div class="form-group">
                        <label for="exampleInputFile">เพิ่มรูปภาพที่ <?php echo $first_vacant_picture;?> :: </label>
                        <input type="file" name="myfile" size="20">
                    </div>       

                    <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">เพิ่ม</button>
                        </div>
                    </div>
                </form>

            </div>    
        <?php } ?>

        <div class="box__head box__head--info">
            การจัดการยูทูป
        </div>    

        <?php if( $arr_youtube ){ ?>
            
            <div class="box__body box__body--info">
                
                <?php foreach( $arr_youtube as $youtube ){ ?>

                        <h5>รูปที่ <?php echo $youtube->media_order;?></h5>
                        <?php echo $youtube->html;?>
                        <div class="two_flex_column" style="margin-top:10px">
                            <div>
                            </div>
                            <div>
                                <a href="<?php echo base_url(["Media","deleteYoutube","post", $post_id, $youtube->media_order ]);?>" class="btn btn-warning">ลบ</a>
                            </div>
                        </div>

                <?php } ?>

            </div>

        <?php } ?>

        <?php if($first_vacant_youtube){ ?>

            <div class="box__body box__body--info">

                <form action="<?php echo base_url(["Media","addYoutube","post",$post_id, $first_vacant_youtube]);?>" method="post" accept-charset="utf-8" style="margin-top:10px">
                    <div class="form-group">
                        <label for="soundfile">เพิ่มวิดิโอยูทูปหมายเลข <?php echo $first_vacant_youtube;?> :: </label>
                        <input type="text" class="form-control" name="youtube">
                    </div>
                    <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">เพิ่ม</button>
                        </div>
                    </div>
                </form>

            </div>    
        <?php } ?>    

        <div class="box__head box__head--info">
            การจัดการแฟ้มเสียง
        </div>    

        <?php if( $arr_sound ){ ?>
            
            <div class="box__body box__body--info">
                
                <?php foreach( $arr_sound as $sound ){ ?>

                        <h5>รูปที่ <?php echo $sound->media_order;?></h5>
                        <?php echo $sound->html;?>
                        <div class="two_flex_column" style="margin-top:10px">
                            <div>
                            </div>
                            <div>
                                <a href="<?php echo base_url(["Media","deleteSound","post", $post_id, $sound->media_order ]);?>" class="btn btn-warning">ลบ</a>
                            </div>
                        </div>

                <?php } ?>

            </div>

        <?php } ?>

        <?php if($first_vacant_sound){ ?>

            <div class="box__body box__body--info">

                <form action="<?php echo base_url(["Media","addSound","post",$post_id, $first_vacant_sound]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
                    <div class="form-group">
                        <label for="exampleInputFile">เพิ่มแฟ้มเสียงที่ <?php echo $first_vacant_sound;?> :: </label>
                        <input type="file" name="myfile" size="20">
                    </div>       

                    <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">เพิ่ม</button>
                        </div>
                    </div>
                </form>

            </div>    
        <?php } ?>



    </div>

<?php } ?>    