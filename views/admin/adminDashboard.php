<form id="acera-settings" method="post">
<?php include "template/header.php"?>

<?php echo $sidebar;?>


<div id="main">

    <div class="topTabs">

        <div id="topTabs-container-home" data-easytabs="true">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 style="display:inline-block" class="secTitle">General Settings</h1>
                    <input style='float:right' name="save" class="btn" type="submit" value="Save changes" />
                    <!--<span class="secExtra">Welcome</span>
                </div> <!-- /SecInfo -->
                </div>

            </div><!-- /topTabs-header -->



        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div>

    <div class="fluid">
        <div class="widget leftcontent grid12">

            <div class="widget-content pad20">



<div class="tab-content" id="se-define-parameters">

    <div class="separator">
        <h4>Affiliate Variable</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input class="acera-fullwidth" id="affiliate_variable" name="affiliate_variable" type="text" value="<?php echo $settings['affiliate_variable'];?>" />
            <p class="description">Please insert the variable you would like to use within your URL to identify affiliates.<br><br>EXAMPLE : If you enter 'aff' then your URL will look like this.<br>http://YourDomain.com/?aff=YourAffiliateCode</p>
        </div>
    </div>
    <div class="separator">
        <h4>Default User</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <input class="acera-fullwidth" id="default_user" name="default_user" type="text" value="<?php echo $settings['default_user'];?>" />
            <p class="description">Please insert the Wordpress login name of the default user.</p>
        </div>
    </div>
    <div class="separator">
        <h4>Un-Affiliated Traffic</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>
            <label for="se_unaffiliated_traffic0">
                <input type="radio" id="se_unaffiliated_traffic0" name="no_affiliate" value="0" <?php checked($settings['no_affiliate'], 0);?>  />
                Default
            </label>
            <label for="se_unaffiliated_traffic1">
                <input type="radio" id="se_unaffiliated_traffic1" name="no_affiliate" value="1" <?php checked($settings['no_affiliate'],1);?> />
                Random                        </label>
            <div id="showRandom" style="display:<?php if($settings['no_affiliate'] == 1) echo "box"; else echo "none";?>">
                <input type="hidden" value="<?php echo $settings['hidden-excludeList'];?>" id="excludeListValues"/>

                <p class=""> Excluded Usernames List:</p>
                <input type="text" class=" tm-input-warning" id="excludeList" name="excludeList" style="display:none;"/>



                <?php wp_dropdown_users(array('name'=>'users_list', 'class'=>'inline-block'));?>
                <a id="addExclude" class="button-primary">Exclude</a>
                <br/>
                <br/>

                <input type="hidden" value="<?php echo $settings['hidden-includeList'];?>" id="includeListValues"/>

                <p class=""> Pick Only From This Usernames List:</p>
                <input type="text" class=" tm-input-success" id="includeList" name="includeList" style="display:none;"/>

                <?php wp_dropdown_users(array('name'=>'users_list_include', 'class'=>'inline-block'));?>
                <a id="addInclude" class="button-primary">Include</a>


            </div>
            <p class="description">Please choose how you would like to assign traffic that does not include an affiliate link.<br><br>If you choose DEFAULT USER, then all traffic that does not have an assigned affiliate will be credited to the default user annotated above.<br><br>If you choose RANDOM USER, then all traffic that does not have an assigned affiliate will be credited to a random member of your team.</p>

        </div>
    </div>

<!--    <div class="separator">-->
<!--        <h4>Enable Viral Sharing Buttons</h4>-->
<!---->
<!--        <div class="settings-content">-->
<!--            <div class="acera_image_preview">-->
<!--            </div>-->
<!---->
<!--            <input id="slider-commtwitter"  class="sl" type="checkbox" name="enable_visitors"  --><?php //checked($settings['enable_visitors'], 1);?><!-->
<!--            <label class="slider aqua" for="slider-commtwitter"></label>-->
<!---->
<!---->
<!--            <p class="description">Enable the viral sharing buttons if you want sharing buttons to appear on all pages for non-members who browse your site.<br><br>When shares are made using these buttons, the shares will be shortened and tracked as normal and will include the affiliate link of the member who is currently cookied on the site.</p>-->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="separator">-->
<!--        <h4>Viral Sharing Buttons Template</h4>-->
<!---->
<!--        <div class="settings-content">-->
<!--            <div class="acera_image_preview">-->
<!--            </div>-->
<!--            --><?php
//            // default value
//            if($settings['vbs_template']=='')
//            {
//                $settings['vbs_template']='light';
//            }
//            foreach($templates as $folder=>$attributes)
//            {?>
<!--                <label for="vbs_template_--><?php //echo $folder;?><!--">-->
<!--                    <input type="radio" id="vsb_template_--><?php //echo $folder;?><!--" name="vsb_template" value="--><?php //echo $folder;?><!--" --><?php //checked($settings['vsb_template'], "$folder");?><!--  />-->
<!--                    --><?php //echo $attributes['name'];?>
<!--                </label>-->
<!---->
<!--            --><?php //}?>
<!---->
<!--            <p class="description">Select a skin for the viral sharing buttons</p>-->
<!--        </div>-->
<!--    </div>-->


    <div class="separator">
        <h4>Enable Sharing Buttons At The Beginning Of A Post</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>

            <input id="slider-enable_beginning"  class="sl" type="checkbox" name="enable_beginning"  <?php checked($settings['enable_beginning'], 1);?>>
            <label class="slider aqua" for="slider-enable_beginning"></label>

            <!-- <input class="acera-fullwidth" id="default_user" name="enable_visitors" type="checkbox" value="1" <?php checked($settings['enable_beginning'], 1);?> /> -->
            <p class="description">Enable the sharing buttons if you want sharing buttons to appear at the beginning of each post on your site.<br><br>When shares are made using these buttons, the shares will be shortened and tracked as normal and will include the affiliate link of the member who is currently cookied on the site.</p>
        </div>
    </div>

    <div class="separator">
        <h4>Enable Sharing Buttons At The End Of A Post</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>

            <input id="slider-enable_end"  class="sl" type="checkbox" name="enable_end"  <?php checked($settings['enable_end'], 1);?>>
            <label class="slider aqua" for="slider-enable_end"></label>

            <!-- <input class="acera-fullwidth" id="default_user" name="enable_visitors" type="checkbox" value="1" <?php checked($settings['enable_end'], 1);?> /> -->
            <p class="description">Enable the sharing buttons if you want sharing buttons to appear at the end of each post on your site.<br><br>When shares are made using these buttons, the shares will be shortened and tracked as normal and will include the affiliate link of the member who is currently cookied on the site.</p>
        </div>
    </div>



    <div class="separator">
        <h4>Enable Sharengine Button</h4>

        <div class="settings-content">
            <div class="acera_image_preview">
            </div>

            <input id="slider-enable_sharengine_button"  class="sl" type="checkbox" name="enable_sharengine_button"  <?php checked($settings['enable_sharengine_button'], 1);?>>
            <label class="slider aqua" for="slider-enable_sharengine_button"></label>

            <!-- <input class="acera-fullwidth" id="default_user" name="enable_visitors" type="checkbox" value="1" <?php checked($settings['enable_end'], 1);?> /> -->
            <p class="description">Enable the Sharengine button for your team<br><br></p>
        </div>
    </div>







</div>
</form>



</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>




