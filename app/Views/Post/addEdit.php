<div class="card-info">
    <div class="card-info card-info_body">

        <form role="form" method="post">
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <textarea class="form-control" name="post_title" rows="1"><?php echo $post->post_title;?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>คำนำ</strong> :: </label>
                <textarea class="form-control" name="post_intro" rows="4"><?php echo $post->post_intro;?></textarea>
           </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>เนื่อหา</strong> :: </label>
                <textarea class="form-control" name="post_content" rows="5"><?php echo $post->post_content;?></textarea>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>การจัดเรียง</strong> :: </label>
                <input type="text" class="form-control" name="post_sort" value="<?php echo $post->post_sort;?>">
            </div>
                        
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>กลุ่มบทความ</strong> :: </label>

                                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="15" name="postCategory_id" value="15">
                        <label for="15" class="custom-control-label">ทั่วไป</label>
                    </div>                
                                    
                            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>การแสดงผล</strong> ::</label>

                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="1" name="post_publishstatus" value="1" checked="">
                    <label for="1" class="custom-control-label">แสดงทันที</label>
                </div>

                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="0" name="post_publishstatus" value="0">
                    <label for="0" class="custom-control-label">ร่าง</label>
                </div>


            </div>

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">ปรับปรุง</button>
                </div>
            </div>

        </form>    




    </div>
</div>