<div class="box">

    <div class="box__body box__body--info">
        <form method="post" accept-charset="utf-8" style="margin-top:10px">
            <div class="form-group">
                <label for="soundfile">จำนวนบัตรคำปัจจุบัน <?php echo $num_card;?> ข้อ</label>
                <input type="number" class="form-control" name="required_num" id="required_num" min="<?php echo $num_card + 1;?>" 
                       placeholder=">=<?php echo $num_card + 1;?>">
            </div>
            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                </div>
            </div>
        </form>
    </div>

</div>