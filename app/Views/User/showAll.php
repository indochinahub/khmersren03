<?php echo $pagination_link;?>

<div class="box">

    <?php foreach( $arr_user as $user){ ?>

        <div class="box__body box__body--info">
            <div style="display:flex;justify-content:flex-start">
                <div>
                    <a href="<?php echo base_url(["User","myProfile", $user->user_id]);?>"> 
                        <img style="border-radius:5%;border-style:solid;border-width:1px;border-color:black;width:100px;height:auto" 
                        class="card-img-top" src="<?php echo $user->avatar_url;?>" 
                        alt="<?php echo $user->display_name;?>">
                    </a>                        
                </div>
                <div style="padding-left:15px">
                    <strong><?php echo $user->display_name;?></strong><br>
                    บัตรคำรอทบทวน ::<?php echo $user->num_card_to_review_today."/".$user->num_card_to_review_tomorrow;?><br>
                    เมื่อ :: <?php echo $user->user_visittime;?>
                </div>
            </div>    
        </div>

    <?php } ?>

</div>