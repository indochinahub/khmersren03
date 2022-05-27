
<?php if( $page_title != FALSE && $page_link != FALSE){ ?>

    <div style="padding:10px">
        <div>
            <?php if( $page_title != FALSE ){ ?>
                <h3 style="margin-bottom: 0px;">
                    <?php echo $page_title;?>
                </h3>
            <?php } ?>
        </div>
        <div>
            <?php if($page_link != FALSE ){ ?>
                [ <a href="<?php echo $page_link[1];?>"><?php echo $page_link[0];?></a> ] 
            <?php } ?>
            
        </div>                
    </div>
    
<?php } ?>
