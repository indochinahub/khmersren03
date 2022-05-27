<div class="box">
    <div class="box__body box__body--warning">
        <h3><?php echo $page_title;?></h3>
        <p><?php echo $what_happened;?></p>
        <p><?php echo $what_todo;?></p>
    </div>

    <div class="two_flex_column" style="padding:10px">
        <div>
            <a href="<?php echo $btnLink_toConfirm;?>" class="btn btn-danger"><?php echo $btnText_toConfirm;?></a>        
        </div>
        <div>
            <a href="<?php echo $btnLink_toCancle;?>" class="btn btn-primary"><?php echo $btnText_toCancle;?></a>
        </div>
    </div>

</div>