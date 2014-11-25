<div rel="se_enable_user_field_1">
    <?php $content = unserialize($content); ?>
    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Tweet Content</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <textarea name="to_update[twitter][content]" class="message" maxlength="118" size="140"><?php echo $content['content'];?></textarea>
            <p class="counter"></p>
        </div>
    </div>

    <div class="separator">
        <div class="label">
            <label for="se_user_field1_desc">Landing Page URL:</label>
        </div>
        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input type="text" class="acera-fullwidth" id="se_tweet" name="to_update[twitter][link]" placeholder="URL" value="<?php echo $content['link'];?>">
            <p class="description">The URL you want the tweet to land on.</p>
        </div>
    </div>

    <input type="hidden" name="to_update[twitter][id]" value="<?php echo $id;?>"/>

</div>