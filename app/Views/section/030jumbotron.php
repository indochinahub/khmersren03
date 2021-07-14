        <!-- Page Content  -->
        <div id="content">
            <div style="display: flex;padding:10px;background-color:#e6a510;">

                <?php if( $loggedin_user === false){ ?>

                    <div>
                        <a href="<?php echo base_url();?>">
                            <img class="image_border" src="<?php echo base_url(["asset","site_image","banner.jpg"]);?>" width="100" height="100" alt="User Avatar">
                        </a>
                    </div>
                    <div style="padding:10px 0 0 20px;">
                            <h2>Khmersren</h2>
                            <h4>เทคโนโลยีเพื่อการเรียนรู้</h4>
                    </div>

                <?php }else{ ?>

                    <div>
                        <a href="<?php echo base_url();?>">
                            <img class="image_border" src="<?php echo $avatar_url;?>" width="100" height="100" alt="User Avatar">
                        </a>
                    </div>
                    <div style="padding:10px 0 0 20px;">
                            <h2><?php echo $loggedin_user->displayname;?></h2>
                            <h4>xxxxxxx</h4>
                    </div>


                <?php } ?>




            </div>
    