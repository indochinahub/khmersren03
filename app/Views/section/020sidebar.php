<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header" style="display: flex;">
                <div>
                    <a href="<?php echo base_url(); ?>">
                        <img class="image_border" src="<?php echo $user_avatar_url; ?>" width="50" height="50" alt="User Avatar">
                    </a>
                </div>

                <div style="padding:10px 0 0 20px;">
                    <a href="<?php echo base_url(); ?>">
                        โปรไฟล์
                    </a>
                </div>
            </div>

            <ul class="list-unstyled components">


                    <?php if ($loggedin_user === false) {?>

                        <li>
                            <a href="<?php echo base_url(["User", "login"]); ?>"><i class="fas fa-angle-double-right"></i> เข้าสู่ระบบ</a>
                        </li>

                    <?php } else {?>

                        <div class="sidebar_section">เมนูส่วนตัว</div>

                        <li>
                            <a href="<?php echo base_url(["User", "myProfile", $loggedin_user->user_id]); ?>"><i class="fas fa-angle-double-right"></i> โปรไฟล์ของฉัน</a>
                        </li>

                        <div class="sidebar_section"></div>

                        <li>
                            <a href="<?php echo base_url(["User", "logout"]); ?>"><i class="fas fa-angle-double-right"></i> ออกจากระบบ</a>
                        </li>

                    <?php }?>

                <div class="sidebar_section">เมนูของเว็บ</div>

                <li>
                    <a href="<?php echo base_url(); ?>"><i class="fas fa-angle-double-right"></i> หน้าแรก</a>
                </li>

                <li>
                    <a href="<?php echo base_url(["Course", "showAll"]); ?>"><i class="fas fa-angle-double-right"></i> วิชาทั้งหมด</a>
                </li>

                <li>
                    <a href="<?php echo base_url(["Cardcomment", "showAll"]); ?>"><i class="fas fa-angle-double-right"></i> ความเห็นทั้งหมด</a>
                </li>

                <li>
                    <a href="<?php echo base_url(["User", "showAll"]); ?>"><i class="fas fa-angle-double-right"></i> ผู้ใช้ทั้งหมด</a>
                </li>


                <?php if (($loggedin_user) && ($loggedin_user->user_level >= 3)) {?>

                    <div class="sidebar_section"> เมนูผู้ดูแลระบบ </div>
                    <li>
                        <a href="<?php echo base_url(["Admin", "dashboard"]); ?>"><i class="fas fa-angle-double-right"></i> แดชบอร์ด </a>
                    </li>

                <?php }?>






            </ul>
        </nav>
