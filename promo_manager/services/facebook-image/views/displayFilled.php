<div rel="se_enable_user_field_1">
    <?php $content = unserialize($content);

    ?>
    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Image description</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <textarea name="to_update[facebook-image][description]" class="message"><?php echo stripslashes($content['description']);?></textarea>

        </div>
    </div>

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Image URL:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" class="acera-fullwidth upload_image" id="se_tweet" name="to_update[facebook-image][image_url]" placeholder="URL" value="<?php echo stripslashes($content['image_url']);?>">
            <p class="description"><button class="button-primary upload_image_button">Upload</button></p>
        </div>
    </div>

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">URL:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" class="acera-fullwidth" id="se_tweet" name="to_update[facebook-image][url]" placeholder="URL" value="<?php echo $content['url'];?>">
            <p class="description">The URL.</p>
        </div>
    </div>
    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">URL Title:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" class="acera-fullwidth " id="se_tweet" name="to_update[facebook-image][url_title]" placeholder="URL" value="<?php echo stripslashes($content['url_title']);?>">
            <p class="description">The URL Title.</p>
        </div>
    </div>

    <input type="hidden" name="to_update[facebook-image][id]" value="<?php echo $id;?>"/>

</div>