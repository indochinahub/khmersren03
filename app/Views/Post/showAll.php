<?php echo $pagination_link;?>

<div class="card-info">

    <?php foreach( $arr_post as $post ){ ?>

        <div class="card-info card-info_body">

            <div>
                <h5><a href="#"><?php echo $post->post_title;?></a></h5>
                <h6>
                    [02 ส.ค. 2564 07:02 น. 
                    โดย <a href="http://www.khmersren.com/Profile/myProfile/6">วิทยา วิจิตร</a>]

                </h6>
            </div>

            <div style="margin-bottom:15px">
                    ในเดือนกรกฎาคม กัมพูชามีผู้เสียชีวิตเนื่องจากโควิด 19 เกือบ 800 คน <br>
                    <div style="border:1px solid black">
                        <img src="http://www.khmersren.com/assets/images/post_media/003381.jpg" class="img-fluid">
                    </div>            
            </div>

            <div class="two_flex_column" style="margin:10px">
                <div>
                    <a href="http://www.khmersren.com/Post/showByCategory/17">
                        <strong>#เรียนเขมรจากข่าว</strong>
                    </a>
                    [125]
                </div>
                <div>
                    <a href="http://www.khmersren.com/Profile/showPost/337" class="btn btn-sm btn-primary">ถัดไป</a>
                </div>
            </div>
            
        </div>

    <?php } ?>

</div>

<?php echo $pagination_link;?>
