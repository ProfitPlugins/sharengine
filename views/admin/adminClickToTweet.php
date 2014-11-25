<form id="acera-settings" method="post">
    <div id="acera-header">
        <center><img src="https://lh4.googleusercontent.com/-lMwBYtoHKoU/UlSOgKwt6pI/AAAAAAAADHE/5kFeCnUl_-Q/w350-h100-no/sharengine_header_logo.png"></center>
    </div>

    <?php echo $sidebar;?>




    <div id="acera-content">




        <div class="tab-content" id="se-define-parameters">
            <div class="acera-settings-headline">
                <h2>Click to Tweet Management</h2>
                <input name="save" class="save-button" type="submit" value="Save tweets" />
            </div>


            <?php

            foreach($data['se_existing_tweets'] as $field_nr=>$v)
            {


                if($v['se_enabled'])
                    $display='block';
                else
                    $display='none';
                ?>

                <div rel="se_enable_user_field_<?php echo $v['id'];?>">
                    <input type='hidden' name="se_existing_tweets[<?php echo $field_nr+1;?>][id]" value="<?php echo $v['id'];?>"/>
                    <div class="separator">
                        <div class="label">
                            <label for="se_user_field1_desc">Tweet Content</label>
                        </div>
                        <div class="settings-content">
                            <div class="acera_image_preview">
                            </div>
                            <textarea size="140" class='message' maxlength="118" name="se_existing_tweets[<?php echo $field_nr+1;?>][content]"/><?php echo $v['content'];?></textarea>
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
                            <input type="text" placeholder="URL" name="se_existing_tweets[<?php echo $field_nr+1;?>][link]" id="se_tweet" value="<?php echo $v['link'];?>" class="acera-fullwidth">
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
                            <input type="text" class='tm-input tm-tag tm-input-info' placeholder="Tags for this tweet" name="se_existing_tweets[<?php echo $field_nr+1;?>][tags]" id="se_tweet"  value="<?php echo $v['tags'];?>" class="acera-fullwidth">
                            <p class="description"></p>
                        </div>
                    </div>
                </div>



            <?php
            }
            ?>


        </div>
        <div id='tweetsPlaceholder'></div>


        <input type='hidden' id='fieldsCount' name='fieldsCount'value ='<?php echo $fields_nr;?>' />

        <a href='#' id='addNewTweet' ><img src='<?php echo SE_IMAGES_URL;?>admin/twitter_add.png'/> </a>
</form>



















