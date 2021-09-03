<div class="box">
    <div class="box__body box__body--info">

        <form method="post">

            <div class="form-group">
                <label for="user_username">Email</label>
                <input type="email" class="form-control" name="user_username" id="user_username" value="<?php echo $user->user_username;?>"
                    readonly
                >
            </div>

            <div class="form-group">
                <label for="user_password">Password</label>
                <input type="number" class="form-control" name="user_password" id="user_password" 
                    value="<?php echo $user->user_password;?>"
                >
            </div>


            <div class="form-group">
                <label for="user_display_name">Display Name</label>
                <input type="text" class="form-control" name="user_display_name" id="user_display_name" 
                    value="<?php echo $user->user_display_name;?>"
                >
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
    <div class="box__body box__body--info">
        <div style="border:1px solid black">
            <img src="http://www.khmersren.com/asset/media/post_media/003701.webp" class="img-fluid">
        </div>
        <div class="two_flex_column" style="margin-top:10px">
            <div>
            </div>
            <div>
                <a href="http://www.khmersren.com/Media/deletePicture/post/370/1" class="btn btn-warning">ลบ</a>
            </div>
        </div>        
    </div>

</div>