
<?php foreach( $arr_card as $card ){ ?>

    <div class="card-danger">
        <div class="card-danger card-danger_body">
            <h5>บัตรคำหมายเลข <?php echo $card->card_sort;?></h5>
        </div>
    </div>

    <div class="card-info">

        <div class="card-info card-info_header">
            คำสั่ง
        </div>
        <div class="card-info card-info_body">
            รายละเอียดคำสั่ง
        </div>
        <div class="card-info card-info_header">
            คำตอบ
        </div>
        <div class="card-info card-info_body">
            รายละเอียดคำตอบ
        </div>
        <div class="card-info card-info_header">
            ตัวเลือก
        </div>
        <div class="card-info card-info_body">
            ตัวเลือก 1
        </div>    
        <div class="card-info card-info_body">
            ตัวเลือก 2
        </div>            
        <div class="card-info card-info_body">
            ตัวเลือก 3
        </div>    
        <div class="card-info card-info_body">
            ตัวเลือก 4
        </div>        

    </div>
<?php } ?>