<div class="box">

    <div class="box__body box__body--info">

        <form method="post">
            <div class="form-group">
                <label for="user_username">Email</label>
                <input type="email" class="form-control" name="user_username" id="user_username" value="<?php echo $user_username;?>"
                        placeholder="อีเมล์"
                >
                <?php if( isset($user_username_error) && $user_username_error != "" ){ ?>
                    <div class="form-error">[<?php echo $user_username_error;?>]</div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="user_password">Password</label>
                <input type="number" class="form-control" name="user_password" id="user_password"
                       placeholder="ใช้ตัวเลข 4 หลักเท่านั้น เช่น 4412" value="<?php echo $user_password;?>"
                >
                <?php if( isset($user_password_error) && $user_password_error != "" ){ ?>
                    <div class="form-error">[<?php echo $user_password_error;?>]</div>
                <?php } ?>

            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="number" class="form-control" name="confirm_password" id="confirm_password"
                       placeholder="ทวนรหัสผ่านอีกครั้ง" value="<?php echo $confirm_password;?>"
                >
                <?php if( isset($confirm_password_error) && $confirm_password_error != "" ){ ?>
                    <div class="form-error">[<?php echo $confirm_password_error;?>]</div>
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
</div>







