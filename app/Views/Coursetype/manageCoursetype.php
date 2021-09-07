<div class="box">

    <div class="box__body box__body--warning">

        <div class="two_flex_column" style="margin-bottom:5px;">
            <div>
                <a href="http://127.0.0.1/khmersren03/Admin/importTable" class="btn btn-info">New</a>                
            </div>
            <div>
                <strong>เพิ่มกลุ่มวิชาใหม่</strong>
            </div>
        </div>

    </div>

    <?php foreach( $arr_coursetype as $coursetype){ ?>
        <div class="box__body box__body--info">
            <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <?php echo $coursetype->coursetype_id;?> :: <strong><?php echo $coursetype->coursetype_name;?></strong>
                        <?php if( $coursetype->num_coure ){  echo "[".$coursetype->num_coure."]";}?>
                    </div>
                    <div>
                        <a href="http://127.0.0.1/khmersren03/Admin/exportTable/card/0" class="btn btn-primary">Edit</a>
                        <a href="http://127.0.0.1/khmersren03/Admin/exportTable/card/0" class="btn btn-primary">Delete</a>
                    </div>
            </div>
        </div>
    <?php  }?>

        
</div>