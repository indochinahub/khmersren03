

<?php if(  ($loggedin_user && $total_unread_message > 0 ) 
             &&  $controller_name !== "Message" ){ ?>

    <div class="box">

        <div class="box__head box__head--danger">
            แจ้งเตือน
        </div>

        <div class="box__body box__body--danger">
            
            <div class="two_flex_column">
                    <div>
                        คุณมีข้อความที่ยังไม่ได้อ่าน <strong><?php echo $total_unread_message;?></strong> ข้อความ
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Message","myMessage"]);?>" class="btn btn-primary">ไป</a>
                    </div>
            </div>

        </div>

    </div>

<?php } ?>    