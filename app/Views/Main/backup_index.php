<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Collapsible sidebar using Bootstrap 4</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(["include","css","main_style.css"]);?>">
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

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
                <div class="sidebar_section">section 1</div>
                <li class="active">
                    <a href="#"><i class="fas fa-angle-double-right"></i> Portfolio</a>
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
                <li>
                    <a href="#"><i class="fas fa-angle-double-right"></i> Contact</a>
                </li>
                <div class="sidebar_section">section 1</div>
                <li>
                    <a href="#">Contact</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <div style="display: flex;padding:10px;background-color:#e6a510;">
                <div>
                    <a href="<?php echo base_url();?>">
                        <img class="image_border" src="<?php echo base_url(["include","site_image","banner.jpg"]);?>" width="100" height="100" alt="User Avatar">
                    </a>
                </div>
                <div style="padding:10px 0 0 20px;">
                        <h2>Khmersren.com</h2>
                        <h4>เทคโนโลยีดิจิตัลเพื่อการเรียนรู้</h4>
                </div>
            </div>
    
            <nav class="navbar navbar-dark bg-dark">
                <div>
                    <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-align-center"></i>
                        <span>Menu</span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand" href="#">Khmersren.com</a>
                </div>
            </nav>

            <div style="display:flex;justify-content: space-between;padding:10px">
                <div>
                    <h3>หัวข้อของหน้า</h3>
                </div>
                <div>
                    [ <a href="http://www.google.com">ลิงก์กลับไป</a> ] 
                 </div>                
            </div>

            <div class="box-content">
                <h3>Collapsible Sidebar Using Bootstrap 4</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="line"></div>
            <div class="box-content">
                <h3>Collapsible Sidebar Using Bootstrap 4</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>

            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    A list item
                    <span class="badge badge-primary badge-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    A second list item
                    <span class="badge badge-primary badge-pill">2</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    A third list item
                    <span class="badge badge-primary badge-pill">1</span>
                </li>
            </ul>

            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small>3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small>And some small print.</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small class="text-muted">3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small class="text-muted">And some muted small print.</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small class="text-muted">3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small class="text-muted">And some muted small print.</small>
                </a>
            </div>     

            <div class="card-success">
                <div class="card-success card-success_header">This is Headdrr</div>
                <div class="card-success card-success_body">This is Body</div>
                <div class="card-success card-success_body">This is Body</div>
                <div class="card-success card-success_body">This is Body</div>
            </div>
            
            <div class="card-info">
                <div class="card-info card-info_header">This is Headdrr</div>
                <div class="card-info card-info_body">This is Body</div>
                <div class="card-info card-info_body">This is Body</div>
                <div class="card-info card-info_body">This is Body</div>
            </div>

            <div class="card-danger">
                <div class="card-danger card-danger_header">This is Headdrr</div>
                <div class="card-danger card-danger_body">This is Body</div>
                <div class="card-danger card-danger_body">This is Body</div>
                <div class="card-danger card-danger_body">This is Body</div>
            </div>            


            <div class="footer">
                <strong>จัดทำโดย <span style="color:#e6a510;">Khmersren.com</span></strong><br>
                ติดต่อได้ที่ Fb Fanpage : Khmersren.com<br>
                Line-id : wittaya713
            </div>


        </div>
        
        <!-- End Of Page Content  -->

    </div>



    <div class="overlay"></div>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>