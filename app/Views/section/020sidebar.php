<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                Avatar
            </div>

            <ul class="list-unstyled components">
                <div class="sidebar_section">เมนูส่วนตัว</div>
                <li>                
                    <?php if( $user === false ){ ?>

                            <a href="<?php echo base_url(["User","login"]);?>"><i class="fas fa-angle-double-right"></i> Login</a>
                        
                    <?php }else{ ?>

                            <a href="<?php echo base_url(["User","logout"]);?>"><i class="fas fa-angle-double-right"></i> Logout</a>
                            
                    <?php } ?>
                </li>                

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
                    <a href="<?php echo base_url(["Course","showAll"]);?>"><i class="fas fa-angle-double-right"></i> วิชาทั้งหมด</a>
                </li>
            </ul>
        </nav>
