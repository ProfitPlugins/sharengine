<div class="se_unit_parent">
<h3>Twitter</h3>
<p style='text-align:right'> <button class='se_promotion_action button button-primary' style='float:right' value='Tweet'>Tweet</button></p>
<strong>Tweet Content:</strong>
<p class='se_twitter_content se_data'  sharengine-share="title"><?php echo do_shortcode(stripslashes($tweet['content']));?></p>
<strong>Tweet URL:  </strong>
<p class=''> <a class='se_data se_twitter_url' sharengine-share="url" href='<?php echo $this->addScheme(do_shortcode(stripslashes($tweet['link'])));?>'><?php echo $this->addScheme(do_shortcode(stripslashes($tweet['link'])));?></a></p>
<p class="se_data" style="display:none" sharengine-share="service">twitter</p>
<!-- hidden inputs to make the "tweet" button work -->
<!--
<input type="hidden" name="body" value="<?php echo do_shortcode(stripslashes($tweet['content']));?>"/>
<input type="hidden" name="title" value="<?php echo do_shortcode(stripslashes($tweet['content']));?>"/>

<input type="hidden" name="url" value="<?php echo $this->addScheme(do_shortcode(stripslashes($tweet['link'])));?>"/>
<input type="hidden" name="service" value="twitter"/>-->
<hr/>
</div>