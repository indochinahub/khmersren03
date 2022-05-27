<div class="box">
    <div class="box__body box__body--info">

        <form method="post">

            <div class="form-group">
                <label for="user_username">Email</label>
                <input type="text" class="form-control" name="user_username" id="user_username" value="<?php echo $user->user_username;?>"
                    readonly
                >
            </div>

            <div class="form-group">
                <label for="user_password">Password</label>
                <input type="number" class="form-control" name="user_password" id="user_password" 
                    value="<?php echo $user->user_password;?>"
                >
                <?php if( isset($user_password_error) && $user_password_error != "" ){ ?>
                    <div class="form-error">[<?php echo $user_password_error;?>]</div>
                <?php } ?>                
            </div>


            <div class="form-group">
                <label for="user_display_name">Display Name</label>
                <input type="text" class="form-control" name="user_display_name" id="user_display_name" 
                    value="<?php echo $user->user_display_name;?>"
                    placeholder="ความยาวมากกว่า 6 ตัวอักษร"
                >
                <?php if( isset($user_display_name_error) && $user_display_name_error != "" ){ ?>
                    <div class="form-error">[<?php echo $user_display_name_error;?>]</div>
                <?php } ?>
            </div>            

            <div class="two_flex_column">
                <div>

                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>

    </div>

    <div class="box__head box__head--info">
        รูปภาพ
    </div>

    <?php if( $arr_picture ){ ?>
        
        <div class="box__body box__body--info">
            
            <?php foreach( $arr_picture as $picture ){ ?>

                    <h5>รูปประจำตัว</h5>
                    <?php echo $picture->html;?>
                    <div class="two_flex_column" style="margin-top:10px">
                        <div>
                        </div>
                        <div>
                            <a href="<?php echo base_url(["Media","deletePicture","user", $user->user_id, $picture->media_order ]);?>" class="btn btn-warning">ลบ</a>
                        </div>
                    </div>

            <?php } ?>

        </div>

    <?php } ?>

    <?php if($first_vacant_picture){ ?>

        <div class="box__body box__body--info">

            <form action="<?php echo base_url(["Media","addPicture","user",$user->user_id, $first_vacant_picture]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
                <div class="form-group">
                    <label for="exampleInputFile">เพิ่มรูปประจำตัว <?php echo $first_vacant_picture;?> :: </label>
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