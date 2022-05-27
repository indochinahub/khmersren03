<div class="box">
    <div class="box__body box__body--info">

        <form role="form" method="post">
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <input type="text" class="form-control" name="lesson_title" value="<?php echo $lesson_title;?>">
                <?php if( isset($lesson_title_error) && $lesson_title_error != "" ){ ?>
                    <div class="form-error">[<?php echo $lesson_title_error;?>]</div>
                <?php } ?>

            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>เนื่อหา</strong> :: </label>
                <textarea class="form-control" name="lesson_content" rows="5"><?php echo $lesson_content;?></textarea>
                <?php if( isset($lesson_content_error) && $lesson_content_error != "" ){ ?>
                    <div class="form-error">[<?php echo $lesson_content_error;?>]</div>
                <?php } ?>


            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 10px 0">
                <label><strong>การจัดเรียง</strong> :: </label>
                <input type="text" class="form-control" name="lesson_sort" value="<?php echo $lesson_sort;?>">
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

<?php if( $task === "edit" ){ ?>

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
                                <a href="<?php echo base_url(["Media","deletePicture","lesson", $lesson_id, $picture->media_order ]);?>" class="btn btn-warning">ลบ</a>
                            </div>
                        </div>

                <?php } ?>

            </div>

        <?php } ?>

        <?php if($first_vacant_picture){ ?>

            <div class="box__body box__body--info">

                <form action="<?php echo base_url(["Media","addPicture","lesson",$lesson_id, $first_vacant_picture]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
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
                                <a href="<?php echo base_url(["Media","deleteYoutube","lesson", $lesson_id, $youtube->media_order ]);?>" class="btn btn-warning">ลบ</a>
                            </div>
                        </div>

                <?php } ?>

            </div>

        <?php } ?>

        <?php if($first_vacant_youtube){ ?>

            <div class="box__body box__body--info">

                <form action="<?php echo base_url(["Media","addYoutube","lesson",$lesson_id, $first_vacant_youtube]);?>" method="post" accept-charset="utf-8" style="margin-top:10px">
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

    </div>

<?php } ?>    