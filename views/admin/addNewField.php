<?php
    //$field_nr  - current_field_number
?>
<div class="separator">
    <h4>Enable Affiliate Field #<?php echo $field_nr+1;?></h4>
    <div class="settings-content">
        <div class="acera_image_preview">
        </div>
        <label for="se_enable_user_field_<?php echo $field_nr+1;?>">
            <input type="checkbox"  id="se_enable_user_field_<?php echo $field_nr+1;?>" name="se_enabled[<?php echo $field_nr+1;?>]" class="show_hide">
            Enable                        </label>
        <p class="description">Enable Sharengine affiliate field #<?php echo $field_nr+1;?>.</p>
    </div>
</div>
<div rel="se_enable_user_field_<?php echo $field_nr+1;?>" style="display: none;">
    <div class="separator">
        <h4>Affiliate Field #<?php echo $field_nr+1;?></h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" value="EXAMPLE : My Lead System Pro" name="se_field[<?php echo $field_nr+1;?>]" id="se_user_field1" class="acera-fullwidth">
            <p class="description">Enter the heading you would like to show in the affiliate members profile.<br>This heading should clearly indicate the affiliate program that this field will represent on your blog.</p>
        </div>
    </div>
    <div class="separator">
        <h4>Affiliate Field #<?php echo $field_nr+1;?> - Description</h4>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" value="EXAMPLE : Enter your MLSP username." name="se_description[<?php echo $field_nr+1;?>]" id="se_user_field1_desc" class="acera-fullwidth">
            <p class="description">Enter a description detailing the type of information needed to place in your links.</p>
        </div>
    </div>
</div>
