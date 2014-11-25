<?php
//$field_nr  - current_field_number
?>

<div rel="se_enable_user_field_<?php echo $field_nr+1;?>">

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Content</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <textarea size="140" maxlength="118" class='' name="se_new_shares[<?php echo $field_nr+1;?>][content]"></textarea>
            <p class="description"></p>
        </div>
    </div>

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Image:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" placeholder="Image" class='upload_image' name="se_new_shares[<?php echo $field_nr+1;?>][image]" id="se_tweet" class="acera-fullwidth">
            <p class="description"><button class='button-primary upload_image_button'>Upload</button>.</p>
        </div>
    </div>

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Landing Page URL:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" placeholder="URL" name="se_new_shares[<?php echo $field_nr+1;?>][link]" id="se_tweet" class="acera-fullwidth">
            <p class="description">The URL you want the tweet to land on.</p>
        </div>
    </div>
    <div class="separator">
        <div class="label">
            <label for="se_tweet<?php echo $field_nr+1;?>1">Tags:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" class='tm-input tm-tag tm-input-info' placeholder="Tags for this tweet" name="se_new_shares[<?php echo $field_nr+1;?>][tags]" id="se_tweet" class="acera-fullwidth">
            <p class="description"></p>
        </div>
    </div>
</div>
