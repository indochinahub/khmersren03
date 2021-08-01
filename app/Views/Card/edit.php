<div class="card-info">
    <div class="card-info card-info_header">
        ข้อมูล
    </div>

    <?php foreach( $arr_command as $key=>$command ){ ?>
        <?php if( $command ){ ?>
            <div class="card-info card-info_body">
                <strong>คำสั่งที่ <?php echo ($key + 1);?></strong> ::<br>
                <?php echo $command->html;?>
            </div>        
        <?php } ?>    
    <?php } ?>

    <?php foreach( $arr_choice as $key=>$choice ){ ?>
        <?php if( $choice->a ){ ?>
            <div class="card-info card-info_body">
                <strong>ตัวเลือกที่ <?php echo ($key + 1);?></strong> ::<br>
                <?php if( $choice->a ){ echo "a) ".$choice->a->html;}?>
                <?php if( $choice->b ){ echo "<br>b) ".$choice->b->html;}?>
                <?php if( $choice->c ){ echo "<br>c) ".$choice->c->html;}?>
                <?php if( $choice->d ){ echo "<br>d) ".$choice->c->html;}?>
            </div>        
        <?php } ?>    
    <?php } ?>

    <div class="card-info card-info_header">
        ข้อมูล
    </div>

    <div class="card-info card-info_body">

        <form role="form" method="post">

            <?php foreach( $arr_command as $key=>$command ){ ?>
                <?php if($command){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>คำสั่งที่ <?php echo ($key+1);?></strong> :: </label>
                        <textarea class="form-control" name="<?php echo $command->column_name;?>" rows="2"><?php echo $command->value;?></textarea>
                    </div>
                <?php } ?>
            <?php } ?>            

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">ปรับปรุง</button>
                </div>
            </div>
        </form>

    </div>        

    
    

    
    

</div>