<div class="box">
    <div class="box__head box__head--info">
        ข้อมูล
    </div>

    <?php foreach( $arr_command as $key=>$command ){ ?>
        <?php if( $command ){ ?>
            <div class="box__body box__body--info">
                <strong>คำสั่งที่ <?php echo ($key + 1);?></strong> ::<br>
                <?php echo $command->html;?>
            </div>        
        <?php } ?>    
    <?php } ?>

    <?php foreach( $arr_answer as $key=>$answer ){ ?>
        <?php if( $answer ){ ?>
            <div class="box__body box__body--info">
                <strong>คำตอบที่ <?php echo ($key + 1);?></strong> ::<br>
                <?php echo $answer->html;?>
            </div>        
        <?php } ?>    
    <?php } ?>

    <?php foreach( $arr_choice as $key=>$choice ){ ?>
        <?php if( $choice->a ){ ?>
            <div class="box__body box__body--info">
                <strong>ตัวเลือกที่ <?php echo ($key + 1);?></strong> ::<br>
                <?php if( $choice->a ){ echo "a) ".$choice->a->html;}?>
                <?php if( $choice->b ){ echo "<br>b) ".$choice->b->html;}?>
                <?php if( $choice->c ){ echo "<br>c) ".$choice->c->html;}?>
                <?php if( $choice->d ){ echo "<br>d) ".$choice->c->html;}?>
            </div>        
        <?php } ?>    
    <?php } ?>

    <div class="box__head box__head--info">
        ข้อมูล
    </div>

    <div class="box__body box__body--info">

        <form role="form" method="post">

            <?php foreach( $arr_command as $key=>$command ){ ?>
                <?php if($command){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>คำสั่งที่ <?php echo ($key+1);?></strong> :: </label>
                        <textarea class="form-control" name="<?php echo $command->column_name;?>" rows="2"><?php echo $command->value;?></textarea>
                    </div>
                <?php } ?>
            <?php } ?> 

            <?php foreach( $arr_answer as $key=>$answer ){ ?>
                <?php if($answer){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>คำตอบที่ <?php echo ($key+1);?></strong> :: </label>
                        <textarea class="form-control" name="<?php echo $answer->column_name;?>" rows="2"><?php echo $answer->value;?></textarea>
                    </div>
                <?php } ?>
            <?php } ?> 

            <?php foreach( $arr_choice as $key=>$choice ){ ?>

                <?php if($choice->a){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>ตัวเลือกที่ <?php echo ($key+1);?>a</strong> :: </label>
                        <textarea class="form-control" name="<?php echo $choice->a->column_name;?>" rows="2"><?php echo $choice->a->value;?></textarea>
                    </div>
                <?php } ?>

                <?php if($choice->b){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>ตัวเลือกที่ <?php echo ($key+1);?>b</strong> :: </label>
                        <textarea class="form-control" name="<?php echo $choice->b->column_name;?>" rows="2"><?php echo $choice->b->value;?></textarea>
                    </div>
                <?php } ?>   

                <?php if($choice->c){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>ตัวเลือกที่ <?php echo ($key+1);?>c</strong> :: </label>
                        <textarea class="form-control" name="<?php echo $choice->c->column_name;?>" rows="2"><?php echo $choice->c->value;?></textarea>
                    </div>
                <?php } ?>                

                <?php if($choice->d){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong>ตัวเลือกที่ <?php echo ($key+1);?>d</strong> :: </label>
                        <textarea class="form-control" name="<?php echo $choice->d->column_name;?>" rows="2"><?php echo $choice->d->value;?></textarea>
                    </div>
                <?php } ?>                

            <?php } ?> 

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">ปรับปรุง</button>
                </div>
            </div>
            
        </form>

    </div>        

    
    

    
    

</div>