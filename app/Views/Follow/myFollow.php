<div class="box">

    <div class="box__head box__head--info">
        ผู้ที่ <?php echo $display_name;?> ติดตาม
    </div>

    <div class="box__body box__body--info">

        <?php foreach( $arr_of_whom_i_follow as $row_of_user ){ ?>
            
            <div style="display:flex;justify-content:space-evenly">
                                                
                <?php foreach( $row_of_user as $user ){ ?>
                    
                    <?php if($user ){ ?>
                        <div style="background-color:#becae6;width:24%">
                                <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                    src="<?php echo $user->avarta_url;?>">
                                </a><br>
                                <?php echo $user->displayname;?>
                                
                        </div>
                    <?php }else{ ?>
                        <div style="width:24%">
                        </div>
                    <?php } ?>


                <?php } ?>
            </div>

        <?php } ?>      
    
    </div>
    
    <div class="box__head box__head--info">
        ผู้ติดตาม <?php echo $display_name;?> 
    </div>

    <div class="box__body box__body--info">

        <?php foreach( $arr_of_my_follower as $row_of_user ){ ?>
            
            <div style="display:flex;justify-content:space-evenly">
                                                
                <?php foreach( $row_of_user as $user ){ ?>
                    
                    <?php if($user ){ ?>
                        <div style="background-color:#becae6;width:24%">
                                <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                    src="<?php echo $user->avarta_url;?>">
                                </a><br>
                                <?php echo $user->displayname;?>
                                
                        </div>
                    <?php }else{ ?>
                        <div style="width:24%">
                        </div>
                    <?php } ?>


                <?php } ?>
            </div>

        <?php } ?>      
    
    </div>    
</div>