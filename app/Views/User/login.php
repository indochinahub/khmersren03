<div class="box">

    <div class="box__body box__body--info">

        <form action="<?php echo base_url(["User","login"]);?>" method="post">
            <div class="form-group">
                <label for="username">Email</label>
                <input type="text" class="form-control" name="username" id="username" value="">
                <?php if( isset($username_error) && $username_error != "" ){ ?>
                    <div class="form-error">[<?php echo $username_error;?>]</div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" name="password" id="password" maxlength="4" minlength="4">
                <?php if( isset($password_error) && $password_error != "" ){ ?>
                    <div class="form-error">[<?php echo $password_error;?>]</div>
                <?php } ?>
            </div>

            <div class="two_flex_column">
                <div>

                </div>
                <div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>

    </div>

    <div class="box__body box__body--info">
        <a href="<?php echo base_url(["Apply","register"])?>">
            [สมัครสมาชิก]
        </a>
    </div>

    <div class="box__body box__body--info">
        <a href="<?php echo base_url(["Apply","forgetPassword"])?>">
            [ลืมรหัสผ่าน]
        </a>
    </div>    
</div>







