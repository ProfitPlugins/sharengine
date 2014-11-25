
<?php
    foreach($fields as $k=>$field)
    {

        if($field['se_enabled'])
        {
    ?>
        <div class="separator">
            <h4><?php echo $field['se_field'];?> </h4>
            <div class="settings-content">
                <div class="acera_image_preview">
                </div>
                Enabled  <input type="checkbox" value="1" <?php checked($permissions[$k]);?>name="enabled[<?php echo $k;?>]" id="se_user_field1" class="acera-fullwidth">
                <br/><br/>

            </div>
        </div>

<?php
        }
    }
?>
    <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
