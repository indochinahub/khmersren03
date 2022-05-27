        <!-- Page Content  -->
        <div id="content">
            <!-- AD unit -->
            <div>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6953131140240793"
                    crossorigin="anonymous">
                </script>
                <!-- khmersren_ad_unit -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-6953131140240793"
                    data-ad-slot="1716113290"
                    data-ad-format="auto"
                    data-full-width-responsive="true">
                </ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div style="display: flex;padding:10px;background-color:#e6a510;">

                <?php if( $member !== false){ ?>

                    <div>
                        <a href="<?php echo base_url();?>">
                            <img class="image_border" src="<?php echo $member_avatar_url;?>" width="100" height="100" alt="User Avatar">
                        </a>
                    </div>
                    <div style="padding:10px 0 0 20px;">
                            <h2><?php echo $member->displayname;?></h2>
                            <h4><?php echo get_userlevel_text($member->user_level);?></h4>
                    </div>

                <?php }elseif( $loggedin_user !== false){ ?>

                    <div>
                        <a href="<?php echo base_url();?>">
                            <img class="image_border" src="<?php echo $user_avatar_url;?>" width="100" height="100" alt="User Avatar">
                        </a>
                    </div>
                    <div style="padding:10px 0 0 20px;">
                            <h2><?php echo $loggedin_user->displayname;?></h2>
                            <h4><?php echo get_userlevel_text($loggedin_user->user_level);?></h4>
                    </div>

                <?php }else{ ?>

                    <div>
                        <a href="<?php echo base_url();?>">
                            <img class="image_border" src="<?php echo base_url(["asset","site_image","banner.jpg"]);?>" width="100" height="100" alt="User Avatar">
                        </a>
                    </div>
                    <div style="padding:10px 0 0 20px;">
                            <h2>Khmersren</h2>
                            <h4>เทคโนโลยีเพื่อการเรียนรู้</h4>
                    </div>

                <?php } ?>




            </div>
    