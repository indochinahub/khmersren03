<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header" style="display: flex;">
                <div>
                    <a href="<?php echo base_url();?>">
                        <img class="image_border" src="<?php echo $user_avatar_url;?>" width="50" height="50" alt="User Avatar">
                    </a>
                </div>

                <div style="padding:10px 0 0 20px;">
                    <a href="<?php echo base_url();?>">
                        โปรไฟล์ของฉัน
                    </a>
                </div>
            </div>

            <ul class="list-unstyled components">
                <div class="sidebar_section">เมนูส่วนตัว</div>
                
                    <?php if( $loggedin_user === false ){ ?>

                        <li>                
                            <a href="<?php echo base_url(["User","login"]);?>"><i class="fas fa-angle-double-right"></i> เข้าสู่ระบบ</a>
                        </li>                

                    <?php }else{ ?>

                        <li>                
                            <a href="<?php echo base_url(["Profile","member", $loggedin_user->user_id]);?>"><i class="fas fa-angle-double-right"></i> โปรไฟล์ของฉัน</a>
                        </li>                

                        <li>                
                            <a href="<?php echo base_url(["Profile","deck", $loggedin_user->user_id]);?>"><i class="fas fa-angle-double-right"></i> บัตรคำของฉัน</a>
                        </li>                

                        <li>                
                            <a href="<?php echo base_url(["User","logout"]);?>"><i class="fas fa-angle-double-right"></i> ออกจากระบบ</a>
                        </li>
                        
                    <?php } ?>
                

                <li>
                    <a href="#"><i class="fas fa-angle-double-right"></i> Contact</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-angle-double-right"></i> Contact</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-angle-double-right"></i> Contact</a>
                </li>

                <div class="sidebar_section">เมนูของเว็บ</div>

                <li>
                    <a href="<?php echo base_url();?>"><i class="fas fa-angle-double-right"></i> หน้าแรก</a>
                </li>

                <li>
                    <a href="<?php echo base_url(["Course","showAll"]);?>"><i class="fas fa-angle-double-right"></i> วิชาทั้งหมด</a>
                </li>

                <li>
                    <a href="<?php echo base_url(["Cardcomment","showAll"]);?>"><i class="fas fa-angle-double-right"></i> ความเห็นทั้งหมด</a>
                </li>                

            </ul>
        </nav>
