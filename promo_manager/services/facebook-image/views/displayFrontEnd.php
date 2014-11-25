<div class="se_unit_parent">

<h3>Facebook Image</h3>
<p style='text-align:right'> <button class='se_promotion_action button button-primary' style='float:right' value='Share It'>Share it!</button></p>
<strong>Image description:</strong>
<p class='se_twitter_content se_data'  sharengine-share="body"><?php echo htmlspecialchars (do_shortcode(stripslashes($pin['description'])),ENT_QUOTES, "UTF-8" );?></p>
<strong>URL:  </strong>
<p class=''> <a class='se_data se_twitter_url' sharengine-share="url" href='<?php echo $this->addScheme(do_shortcode(stripslashes($pin['url'])));?>'><?php echo $this->addScheme(do_shortcode(stripslashes($pin['url'])));?></a></p>

<strong>Image URL:</strong>
<p class=''> <a class=''target="_blank" href='<?php echo $this->addScheme(do_shortcode(stripslashes($pin['image_url'])));?>'><?php echo $this->addScheme(do_shortcode(stripslashes($pin['image_url'])));?></a></p>

<strong>URL title:</strong>
<p class=''> <?php echo do_shortcode(stripslashes($pin['url_title']));?></p>

<p class="se_data" style="display:none" sharengine-share="service">facebook-image</p>
<p class="se_data" style="display:none" sharengine-share="image"><?php echo $this->addScheme($pin['image_url']);?></p>
<p class="se_data" style="display:none" sharengine-share="title"><?php echo $pin['url_title'];?></p>

<hr/>
</div>