<div class="box">

    <div class="box__head box__head--info">
        ผู้ที่ <?php echo $display_name;?> ติดตาม
    </div>

        <?php foreach( $arr_of_whom_i_follow as $row_of_user ){ ?>
            
            <div class="row4icon">
                                                
                <?php foreach( $row_of_user as $user ){ ?>
                    
                    <?php if($user ){ ?>

                        <div class="row4icon_icon">
                            <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                src="<?php echo $user->avarta_url;?>">
                            </a>
                        </div>

                    <?php }else{ ?>

                        <div class="row4icon_icon">
                        </div>

                    <?php } ?>


                <?php } ?>
            </div>

        <?php } ?>      
    
    
    <div class="box__head box__head--info">
        ผู้ติดตาม <?php echo $display_name;?> 
    </div>

        <?php foreach( $arr_of_my_follower as $row_of_user ){ ?>
            
            <div class="row4icon">
                                                
                <?php foreach( $row_of_user as $user ){ ?>
                    
                    <?php if($user ){ ?>
                        <div class="row4icon_icon">
                                <a href="<?php echo base_url(["User","myProfile",$user->user_id]);?>"> 
                                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" 
                                    src="<?php echo $user->avarta_url;?>">
                                </a>
                        </div>
                    <?php }else{ ?>
                        <div class="row4icon_icon">
                        </div>
                    <?php } ?>

                <?php } ?>
            </div>

        <?php } ?>      
    
    </div>    
</div>