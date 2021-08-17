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
                            โดย [<strong>xxx</strong>]<br>
                            <?php echo $message->message_readdate;?>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>


    <?php }elseif( $message->role === "i_am_sender" ){ ?>

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
                            โดย [<strong>xxxxx</strong>]<br>
                            ส่งเมื่อ <?php echo $message->message_senddate;?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>

<?php } ?>

<div class="card-info">
    <div class="card-info card-info_header">This is Headdrr</div>
    <div class="card-info card-info_body">This is Body</div>
</div>