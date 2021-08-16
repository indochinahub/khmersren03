<div class="card-info">
    <div class="card-info card-info_body">
        <h2>สวัสดีผู้เยี่ยมชมทุกท่าน</h2>
        ยินดีต้อนรับทุกท่านเข้าสู่เว็บไซต์ www.khmersren.com  เว็บไซต์ที่ส่งเสริมการเรียนรู้สิ่งต่างๆ ด้วยตนเอง <br>
        <br>
        สำหรับท่านที่เป็นสมาชิกอยู่แล้ว ท่านสามารถ<strong>เข้าสู่ระบบ</strong> ได้  <a href="http://www.khmersren.com/User/login">[ โดยคลิ๊กที่ลิงก์นี้ ]</a><br>  หรือหากท่านสนใจต้องการใช้งานก็สามารถสมัครขอใช้งานฟรีได้ที่โดยส่งข้อความมาที่ [<a href="https://www.facebook.com/khmersren01">Facebook Fanpage :: Khmersren.com  </a>]        
    </div>
</div>

<div class="card-info">
    <div class="card-info card-info_header">บทความล่าสุด</div>

    <?php foreach( $arr_post as $post ){ ?>

        <div class="card-info card-info_body">

            <div>
                <h5><a href="<?php echo base_url([ "Post","show",$post->post_id ]);?>"><?php echo $post->post_title;?></a></h5>
                <h6 style="margin-top:5px">
                    [ <?php echo $post->post_createddate;?>
                        โดย 
                        <a href="<?php echo base_url( ["User","myProfile", $post->user->user_id]);?>">
                            <?php echo $post->user->displayname;?>
                        </a>]
                </h6>
            </div>

            <div style="margin-bottom:15px">
                <?php echo $post->post_intro;?>
                    
            </div>

            <div class="two_flex_column">
                <div>
                    <a href="<?php echo base_url( ["Post","showBy","Category",$post->postcategory->postcategory_id] );?>">
                        <strong>#<?php echo $post->postcategory->postcategory_title;?></strong>
                    </a>
                    [ <?php echo $post->postcategory_num_card;?> ]
                </div>
                <div>
                    <a href="<?php echo base_url([ "Post","show",$post->post_id ]);?>" class="btn btn-primary">อ่าน</a>
                </div>
            </div>
            
        </div>

    <?php } ?>

</div>

<div class="card-warning">

    <div class="card-warning card-warning_body">
        
        <div class="two_flex_column">
            <div>
                <h5>ดูบัตรคำทั้งหมด</h5>
            </div>
            <div>
                <a href="<?php echo base_url( ["Post","showBy","All"] );?>" class="btn btn-primary">ไป</a>
            </div>
        </div>

    </div>

</div>
