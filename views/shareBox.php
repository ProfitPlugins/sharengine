
<div id='se_modal'>
    <div id='se_modal_header' style='display:none'><h3>Share</h3></div>

    <div id="se_search" style="display: block;">
        <label style="position:absolute;left:-9972em;" for="service-filter">Sharing Service Filter</label>
        <input type="text" placeholder="Find a network" maxlength="50" size="30" id="se_search_box">
    </div>
    <div id='se_modal_content'>
        <?php foreach($links as $network=>$link) {
            if($titles[$network]){
            ?>
                <a class="se_win_<?php echo $network;?> se_win" target='_blank' style="font-weight: bold;" href="<?php echo $network;?>">
                    <span class=" se_win_image se_win_image_<?php echo $network;?>"> </span>
                    <span class="se_win_name"><?php echo $titles[$network];?></span>
                </a>

        <?php }} ?>
    </div>
    <?php
        if(strpos($permalink, '?') !== FALSE)
            $separator = "&";
        else
            $separator = "?";


        if($_COOKIE['se_affiliate'])
            $affiliate = $_COOKIE['se_affiliate'];
        else
        {
            $user_id = get_current_user_id();
            $aff_user = get_user_by( 'id', $user_id );

            $affiliate =$aff_user ->user_login;

        }
    ?>
    <div id='se_details'  style=''>
        <p id="se_title">Original Affiliate URL</p>
        <p id="se_url"><input type='text' name='aff_link' id='aff_link' style='width:300px' value='<?php echo $permalink;?><?php echo $separator;?><?php echo $affiliate_variable;?>=[se_username]'/> <a href='javascript:;' id='se_copy'>Copy</a></p>
    </div>
    <div id='se_footer'>
        <a target="_blank" href="#" id="se_logo">Powered By <?php echo SE_NAME;?></a>

    </div>
</div>
<?php // make sure this shows up on se_enabled posts
global $post;
$se_enabled = get_post_meta($post->ID, 'se_enabled', true);
$options = get_option(SE_OPTIONS);


if(is_single() && $se_enabled && $options['enable_sharengine_button']){?>

<div id='se_share_button'>
    <img src='<?php echo SE_IMAGES_URL;?>share.png'/>
</div>
<?php } ?>