<div class="box">
    <div class="box__body box__body--info">

        <form role="form" method="post">

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Sort</strong> :: </label>
                <input type="text" class="form-control" name="deck_sort" value="<?php echo $deck_sort;?>">
                <?php if( isset($deck_sort_error) && $deck_sort_error != "" ){ ?>
                    <div class="form-error">[<?php echo $deck_sort_error;?>]</div>
                <?php } ?>                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Name</strong> :: </label>
                <input type="text" class="form-control" name="deck_name" value="<?php echo $deck_name;?>">
                <?php if( isset($deck_name_error) && $deck_name_error != "" ){ ?>
                    <div class="form-error">[<?php echo $deck_name_error;?>]</div>
                <?php } ?>                                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Description</strong> :: </label>
                <input type="text" class="form-control" name="deck_description" value="<?php echo $deck_description;?>">
                <?php if( isset($deck_description_error) && $deck_description_error != "" ){ ?>
                    <div class="form-error">[<?php echo $deck_description_error;?>]</div>
                <?php } ?>                                                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>command 1</strong> :: </label>
                <input type="text" class="form-control" name="deck_command1_col" value="<?php echo $deck_command1_col;?>">
                <?php if( isset($deck_command1_col_error) && $deck_command1_col_error != "" ){ ?>
                    <div class="form-error">[<?php echo $deck_command1_col_error;?>]</div>
                <?php } ?>                                                                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Command 2</strong> :: </label>
                <input type="text" class="form-control" name="deck_command2_col" value="<?php echo $deck_command2_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Command 3</strong> :: </label>
                <input type="text" class="form-control" name="deck_command3_col" value="<?php echo $deck_command3_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Command 4</strong> :: </label>
                <input type="text" class="form-control" name="deck_command4_col" value="<?php echo $deck_command4_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Answer 1</strong> :: </label>
                <input type="text" class="form-control" name="deck_answer1_col" value="<?php echo $deck_answer1_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Answer 2</strong> :: </label>
                <input type="text" class="form-control" name="deck_answer2_col" value="<?php echo $deck_answer2_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Answer 3</strong> :: </label>
                <input type="text" class="form-control" name="deck_answer3_col" value="<?php echo $deck_answer3_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 1a</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice1a_col" value="<?php echo $deck_choice1a_col;?>">
                <?php if( isset($deck_choice1a_col_error) && $deck_choice1a_col_error != "" ){ ?>
                    <div class="form-error">[<?php echo $deck_choice1a_col_error;?>]</div>
                <?php } ?>                                                                
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 1b</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice1b_col" value="<?php echo $deck_choice1b_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 1c</strong> :: </label> 
                <input type="text" class="form-control" name="deck_choice1c_col" value="<?php echo $deck_choice1c_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 1d</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice1d_col" value="<?php echo $deck_choice1d_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 2a</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice2a_col" value="<?php echo $deck_choice2a_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 2b</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice2b_col" value="<?php echo $deck_choice2b_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 2c</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice2c_col" value="<?php echo $deck_choice2c_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 2d</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice2d_col" value="<?php echo $deck_choice2d_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 3a</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice3a_col" value="<?php echo $deck_choice3a_col;?>">
            </div>
            
            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 3b</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice3b_col" value="<?php echo $deck_choice3b_col;?>">
            </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 3c</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice3c_col" value="<?php echo $deck_choice3c_col;?>">
            </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 3d</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice3d_col" value="<?php echo $deck_choice3d_col;?>">
            </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 4a</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice4a_col" value="<?php echo $deck_choice4a_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 4b</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice4b_col" value="<?php echo $deck_choice4b_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 4c</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice4c_col" value="<?php echo $deck_choice4c_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>Choice 4d</strong> :: </label>
                <input type="text" class="form-control" name="deck_choice4d_col" value="<?php echo $deck_choice4d_col;?>">
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 15px 0">
                <label><strong>Course</strong> :: </label>
                <select class="custom-select" name="id_cardgroup">

                    <?php foreach( $arr_cardgroup as $cardgroup){ ?>
                        <option value="<?php echo $cardgroup->cardgroup_id;?>"  <?php echo $cardgroup->checked_text;?> >
                            <?php echo $cardgroup->cardgroup_id.":".$cardgroup->cardgroup_name;?>
                        </option>
                    <?php } ?>

                </select>
            </div>            

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