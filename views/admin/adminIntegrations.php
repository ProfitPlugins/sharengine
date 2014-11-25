<form id="acera-settings" method="post">
    <?php include "template/header.php"?>

    <?php echo $sidebar;?>



    <div id="main">
        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle">Integrations Management</h1>
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

                            <?php// var_dump($integrations);?>
                            <?php
                            if($integrations['infusionsoft']['enabled'])
                                $display = "block";
                            else
                                $display = "none";
                            ?>


                            <div class="separator">
                                <h4>Infusionsoft Integration</h4>

                                <div class="settings-content">
                                    <div class="acera_image_preview">
                                    </div>
                                    <label for="se_enable_user_field_<?php echo $field_nr+1;?>">
                                        <input type="checkbox"  id="se_enable_user_field_<?php echo $field_nr+1;?>" name="integrations[infusionsoft][enabled]" class="show_hide" value = "1" <?php checked($integrations['infusionsoft']['enabled']);?>>
                                        Enable                        </label>
                                    <p class="description">Enable the Infusionsoft Tracking Integration</p>
                                </div>
                            </div>
                            <div rel="se_enable_user_field_<?php echo $field_nr+1;?>" style="display: <?php echo $display;?>;">
                                <div class="separator">
                                    <h4>Infusionsoft Subdomain</h4>
                                    <div class="settings-content">
                                        <div class="acera_image_preview">
                                        </div>
                                        <input type="text" value="<?php echo $integrations["infusionsoft"]["subdomain"];?>" name="integrations[infusionsoft][subdomain]" id="se_user_field1" class="acera-fullwidth">
                                        <p class="description">Enter your Infusionsoft subdomain.<br/>
                                            EXAMPLE : https://XXXXXX.Infusionsoft.com</p>
                                    </div>
                                </div>
                                <div class="separator">
                                    <h4>Infusionsoft Referral Tracking Link Code</h4>

                                    <div class="settings-content">
                                        <div class="acera_image_preview">
                                        </div>
                                        <input type="text" value="<?php echo $integrations["infusionsoft"]["referral"];?>" name="integrations[infusionsoft][referral]" id="se_user_field1_desc" class="acera-fullwidth">
                                        <p class="description">Enter your Infusionsoft Referral Tracking Link Code.<br/>
                                            This is the code that you gave the tracking link when you created it in your infusionsoft control panel.</p>
                                    </div>
                                </div>
                            </div>






                    </div>

</form>





</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>















