<div class="se_unit_parent">

<h3>Pinterest</h3>
<p style='text-align:right'> <button class='se_promotion_action button button-primary' style='float:right' value='Pin It'>Pin it</button></p>
<strong>Pin description:</strong>
<p class='se_twitter_content se_data'  sharengine-share="title"><?php echo do_shortcode(stripslashes($pin['description']));?></p>
<strong>URL:  </strong>
<p class=''> <a class='se_data se_twitter_url' sharengine-share="url" href='<?php echo $this->addScheme(do_shortcode(stripslashes($pin['url'])));?>'><?php echo $this->addScheme(do_shortcode(stripslashes($pin['url'])));?></a></p>

<strong>Image URL:</strong>
<p class=''> <a class=''target="_blank" href='<?php echo $this->addScheme(do_shortcode(stripslashes($pin['image_url'])));?>'><?php echo $this->addScheme(do_shortcode(stripslashes($pin['image_url'])));?></a></p>


<p class="se_data" style="display:none" sharengine-share="service">pinterest</p>
<p class="se_data" style="display:none" sharengine-share="image"><?php echo $this->addScheme($pin['image_url']);?></p>

<hr/>
</div>