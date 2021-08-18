<?php foreach($arr_message as $message){ ?>

    <?php if( $message->role === "i_am_reciever" ){ ?>

        <div class="card-info" style="margin-right:40px;margin-bottom:5px"">
            <div class="card-info card-info_body">
                <div class="two_flex_column">
                    <div style="text-align:left">
                        <div>
                            <?php echo $message->message_text;?>
                        </div>
                        <div>
                            โดย [<strong><?php echo $other_displayname;?></strong>]<br>
                            ส่งเมื่อ <?php echo $message->message_senddate;?>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>

    <?php }elseif(  $message->role === "i_am_sender" &&
                    $message->message_text === null &&
                    $message->message_picture01 === null &&
                    $message->message_youtube01 === null
                 ){ ?>

        <div class="card-warning" style="margin-left:40px;margin-bottom:5px">

            <div class="card-warning card-warning_body">

                <div class="two_flex_column">
                    <div>
                        <a href="<?php echo base_url(["Message","delete",$message->message_id]);?>" class="btn btn-danger">ลบ</a>
                    </div>
                    <div>
                        <strong>ลบข้อความนี้</strong>
                    </div>
                </div>                

            </div>

            <div class="card-warning card-warning_body">
            
                <form action="<?php echo base_url(["Media","addPicture","message",$message->message_id,1]);?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" style="margin-top:10px">
                    <div class="form-group">
                        <label for="exampleInputFile">เพิ่มรูปภาพ</label><br>
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

            <div class="card-warning card-warning_body">

                <form action="<?php echo base_url(["Media","addYoutube","message",$message->message_id,1]);?>" method="post" accept-charset="utf-8" style="margin-top:10px">
                    <div class="form-group">
                        <label for="soundfile">เพิ่มวิดิโอยูทูปหมายเลข :: </label>
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

        </div>

    <?php }elseif(   $message->role === "i_am_sender"    ){ ?>

        <div class="card-warning" style="margin-left:40px;margin-bottom:5px">
            <div class="card-warning card-warning_body">

                <div class="two_flex_column">
                    <div>
                    </div>            
                    <div style="text-align:right">
                        <div>
                            <?php echo $message->message_text;?>
                        </div>
                        <div>
                            โดย [<strong><?php echo $user_displayname;?></strong>]<br>
                            <?php echo $message->message_readdate;?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>

<?php } ?>

<div class="card-info">
    <div class="card-info card-info_header">
        ส่งข้อความ
    </div>
    <div class="card-info card-info_body">

        <form role="form" method="post" action="<?php echo base_url(["Message","send",$other->user_id ]);?>">
            
            <div class="form-group">
                <label><strong>เพิ่มข้อความ</strong></label>
                <textarea class="form-control" name="cardcomment_text" rows="2"></textarea>
            </div>
            <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                    </div>
            </div>
        </form>

    </div>

    <div class="card-info card-info_body">

            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <h6>เพิ่มแบบฟอร์มสำหรับสื่อ</h6>
                    </div>
                    <div>
                        <a href="<?php echo base_url( ["Message","addBlank",$other->user_id]);?>" class="btn btn-primary">เพิ่ม</a>
                    </div>
            </div>
    </div>

</div>


